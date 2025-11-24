<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Orders;

use App\Enums\OrderStatus;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Edit extends Component
{
    public Company $tenant;

    public Order $order;

    public ?int $customerId = null;

    public ?int $warehouseId = null;

    public ?string $status = null;

    public ?float $discount = null;

    public ?float $advance = null;

    public ?string $paymentStatus = null;

    // Propriétés pour les nouveaux produits
    public array $productLines = [];

    public float $subtotal = 0;

    public float $totalAmount = 0;

    protected function rules(): array
    {
        return (new UpdateOrderRequest)->rules();
    }

    protected function messages(): array
    {
        return (new UpdateOrderRequest)->messages();
    }

    public function mount(Company $tenant, Order $order)
    {
        $this->tenant = $tenant;
        $this->order = $order;

        $this->fill([
            'customerId' => $this->order->customer_id,
            'warehouseId' => $this->order->warehouse_id,
            'status' => $this->order->status->value,
            'discount' => $this->order->discount,
            'advance' => $this->order->advance,
            'paymentStatus' => $this->order->payment_status->value,
        ]);

        /* $this->productLines = $this->order->products
            ->map(function (OrderProduct $item) {
                return [
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total' => $item->total_price,
                ];
            })->toArray(); */

        // Calculer les totaux initiaux
        $this->calculateInitialTotals();
    }

    /**
     * Permet de savoir si la commande est verrouillée
     */
    #[Computed]
    public function isLocked(): bool
    {
        return in_array($this->status, ['paid', 'delivered', 'cancelled']);
    }

    public function calculateInitialTotals()
    {
        // Sous-total des produits existants
        $existingSubtotal = $this->order->products->sum(function ($item) {
            return $item->total_price;
        });

        // Sous-total des nouveaux produits
        $newSubtotal = collect($this->productLines)->sum('total_price');

        $this->subtotal = $existingSubtotal + $newSubtotal;
        $this->totalAmount = $this->subtotal + ($this->shipping_cost ?? 0);
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
        $this->productLines = array_values($this->productLines);
        $this->calculateInitialTotals();
    }

    public function updatedProductLines($value, $key)
    {
        $parts = explode('.', $key);
        $index = $parts[0];
        $field = $parts[1];

        if ($field === 'product_id' && ! empty($value)) {
            $product = Product::find($value);
            if ($product) {
                $this->productLines[$index]['unit_price'] = $product->price;
                $this->productLines[$index]['available_stock'] = $product->stock_quantity;
                $this->productLines[$index]['quantity'] = 1;
                $this->calculateLineTotal($index);
            }
        } elseif ($field === 'quantity') {
            $this->calculateLineTotal($index);
        }

        $this->calculateInitialTotals();
    }

    public function calculateLineTotal($index)
    {
        $line = $this->productLines[$index];
        $this->productLines[$index]['total_price'] = $line['quantity'] * $line['unit_price'];
    }

    public function updatedShippingCost()
    {
        $this->calculateInitialTotals();
    }

    public function update()
    {
        // Validation des nouveaux produits
        $this->validate([
            'customerId' => 'nullable|exists:customers,id',
            'status' => 'required|in:pending,confirmed,in_preparation,shipped,delivered,cancelled',
            'productLines.*.product_id' => 'required|exists:products,id',
            'productLines.*.quantity' => 'required|integer|min:1',
        ]);

        // Vérifier les stocks pour les nouveaux produits
        foreach ($this->productLines as $index => $line) {
            if (! empty($line['product_id'])) {
                $product = Product::find($line['product_id']);
                if ($product && $line['quantity'] > $product->stock_quantity) {
                    $this->addError("productLines.{$index}.quantity", "La quantité demandée ({$line['quantity']}) dépasse le stock disponible ({$product->stock_quantity}) pour le produit {$product->name}.");

                    return;
                }
            }
        }

        // Mettre à jour la commande
        $orderData = [
            'customer_id' => $this->customerId,
            'warehouse_id' => $this->warehouseId,
            'status' => $this->status,
            'notes' => $this->notes,
            'shipping_cost' => $this->shipping_cost,
            'shipping_address' => $this->shipping_address,
            'billing_address' => $this->billing_address,
            'subtotal' => $this->subtotal,
            'total_amount' => $this->totalAmount,
        ];

        $this->order->update($orderData);

        // Ajouter les nouveaux produits et décrémenter les stocks
        foreach ($this->productLines as $line) {
            if (! empty($line['product_id'])) {
                $product = Product::find($line['product_id']);
                $this->order->products()->attach($line['product_id'], [
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['unit_price'],
                    'total_price' => $line['total_price'],
                ]);

                // Décrémenter le stock
                $product->decreaseStock($line['quantity']);
            }
        }

        $this->dispatch('notify', 'Commande modifiée avec succès.');

    }

    public function render()
    {
        $customers = Customer::where('company_id', $this->tenant->id)->get();
        $products = Product::where('company_id', $this->tenant->id)
            ->where('stock_quantity', '>', 0)
            ->get();

        $warehouses = Warehouse::where('company_id', $this->tenant->id)->get();

        return view('livewire.dashboard.orders.edit', [
            'statuses' => OrderStatus::cases(),
            'customers' => $customers,
            'products' => $products,
            'warehouses' => $warehouses,
        ]);
    }
}
