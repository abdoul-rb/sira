<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Order;

use App\Enums\OrderStatus;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;

class Create extends Component
{
    public Company $tenant;

    public $customer_id = null;

    public $quotation_id = null;

    public $status = null;

    public $notes = null;

    public $shipping_cost = null;

    public $shipping_address = null;

    public $billing_address = null;

    // Propriétés pour les produits
    public $productLines = [];
    public $subtotal = 0;
    public $total_amount = 0;

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
        $this->status = OrderStatus::PENDING->value;

        $this->addProductLine(); // Ajouter une première ligne par défaut
    }

    public function addProductLine()
    {
        $this->productLines[] = [
            'product_id' => null,
            'quantity' => 1,
            'unit_price' => 0,
            'total_price' => 0,
            'available_stock' => 0,
        ];
    }

    public function removeProductLine($index)
    {
        unset($this->productLines[$index]);
        $this->productLines = array_values($this->productLines); // Réindexer
        $this->calculateTotals();
    }

    public function updatedProductLines($value, $key)
    {
        // Extraire l'index et le champ depuis la clé (ex: "0.product_id")
        $parts = explode('.', $key);
        $index = $parts[0];
        $field = $parts[1];

        if ($field === 'product_id' && !empty($value)) {
            $product = Product::find($value);
            
            if ($product) {
                $this->productLines[$index]['unit_price'] = $product->price;
                $this->productLines[$index]['available_stock'] = $product->stock_quantity;
                $this->productLines[$index]['quantity'] = 1; // Reset quantity
                $this->calculateLineTotal($index);
            }
        } elseif ($field === 'quantity') {
            $this->calculateLineTotal($index);
        }

        $this->calculateTotals();
    }

    public function calculateLineTotal($index)
    {
        $line = $this->productLines[$index];
        $this->productLines[$index]['total_price'] = $line['quantity'] * $line['unit_price'];
    }

    public function calculateTotals()
    {
        $this->subtotal = collect($this->productLines)->sum('total_price');
        $this->total_amount = $this->subtotal + ($this->shipping_cost ?? 0);
    }

    public function updatedShippingCost()
    {
        $this->calculateTotals();
    }

    protected function rules(): array
    {
        return (new StoreOrderRequest)->rules();
    }

    public function save()
    {
        // Validation des produits
        $this->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'status' => 'required|in:pending,confirmed,in_preparation,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:1000',
            'shipping_cost' => 'nullable|numeric|min:0',
            'shipping_address' => 'nullable|string|max:255',
            'billing_address' => 'nullable|string|max:255',
            'productLines.*.product_id' => 'required|exists:products,id',
            'productLines.*.quantity' => 'required|integer|min:1',
        ]);

        // Vérifier les stocks
        foreach ($this->productLines as $index => $line) {
            if (!empty($line['product_id'])) {
                $product = Product::find($line['product_id']);
                
                if ($product && $line['quantity'] > $product->stock_quantity) {
                    $this->addError("productLines.{$index}.quantity", "La quantité demandée ({$line['quantity']}) dépasse le stock disponible ({$product->stock_quantity}) pour le produit {$product->name}.");
                    return;
                }
            }
        }

        // Créer la commande
        $orderData = [
            'company_id' => $this->tenant->id,
            'customer_id' => $this->customer_id,
            'quotation_id' => $this->quotation_id,
            'status' => $this->status,
            'notes' => $this->notes,
            'shipping_cost' => $this->shipping_cost,
            'shipping_address' => $this->shipping_address,
            'billing_address' => $this->billing_address,
            'subtotal' => $this->subtotal,
            'total_amount' => $this->total_amount,
        ];

        $order = Order::create($orderData);

        // Attacher les produits et décrémenter les stocks
        foreach ($this->productLines as $line) {
            if (!empty($line['product_id'])) {
                $product = Product::find($line['product_id']);
                
                $order->products()->attach($line['product_id'], [
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['unit_price'],
                    'total_price' => $line['total_price'],
                ]);

                // Décrémenter le stock
                $product->decreaseStock($line['quantity']);
            }
        }

        session()->flash('success', 'Commande créée avec succès.');
        return redirect()->route('dashboard.orders.edit', [$this->tenant, $order]);
    }

    public function render()
    {
        $customers = Customer::where('company_id', $this->tenant->id)->get();
        $products = Product::where('company_id', $this->tenant->id)
            ->where('stock_quantity', '>', 0)
            ->get();

        return view('livewire.dashboard.order.create', [
            'statuses' => OrderStatus::cases(),
            'customers' => $customers,
            'products' => $products,
        ])->extends('layouts.dashboard');
    }
}
