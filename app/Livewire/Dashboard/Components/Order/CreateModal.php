<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Components\Order;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Company;
use App\Enums\OrderStatus;
use App\Models\Warehouse;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Http\Requests\Order\StoreOrderRequest;

class CreateModal extends Component
{
    public Company $tenant;

    public $customer_id = null;

    public $warehouse_id = null;

    public $status = null;

    public $discount = null;

    public $advance = null;

    public $payment_status = null;

    // Propriétés pour les produits
    public $productLines = [];
    public $subtotal = 0;
    public $total_amount = 0;

    protected function rules(): array
    {
        return (new StoreOrderRequest)->rules();
    }

    protected function messages(): array
    {
        return (new StoreOrderRequest)->messages();
    }

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
        $this->status = OrderStatus::PENDING->value;
        $this->discount = 0;
        $this->advance = 0;
        $this->payment_status = PaymentStatus::CASH->value;

        $this->warehouse_id = $this->tenant->defaultWarehouse()->id;

        $this->addProductLine(); // Ajouter une première ligne par défaut
        $this->calculateTotals(); // Calculer les totaux initiaux
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

    public function calculateLineTotal($index)
    {
        $line = $this->productLines[$index];
        $this->productLines[$index]['total_price'] = $line['quantity'] * $line['unit_price'];
    }

    public function calculateTotals()
    {
        $this->subtotal = collect($this->productLines)->sum('total_price');
        $this->total_amount = $this->subtotal - (float) ($this->discount ?? 0);
    }

    public function updatedWarehouseId()
    {
        // Mettre à jour le stock disponible pour tous les produits quand l'entrepôt change
        foreach ($this->productLines as $index => $line) {
            if (!empty($line['product_id'])) {
                $product = Product::find($line['product_id']);
                if ($product && $this->warehouse_id) {
                    $warehouse = Warehouse::find($this->warehouse_id);
                    $this->productLines[$index]['available_stock'] = $warehouse ? $warehouse->getProductStock($product) : 0;
                }
            }
        }
    }

    public function updatedDiscount()
    {
        $this->calculateTotals();
    }

    public function updatedAdvance()
    {
        $this->calculateTotals();
    }

    public function updated($propertyName)
    {
        // Débogage pour voir quels champs changent
        if (in_array($propertyName, ['discount', 'advance'])) {
            $this->calculateTotals();
        }
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
                
                // Afficher le stock disponible dans l'entrepôt sélectionné
                if ($this->warehouse_id) {
                    $warehouse = Warehouse::find($this->warehouse_id);
                    $this->productLines[$index]['available_stock'] = $warehouse ? $warehouse->getProductStock($product) : 0;
                } else {
                    $this->productLines[$index]['available_stock'] = $product->stock_quantity;
                }
                
                $this->productLines[$index]['quantity'] = 1; // Reset quantity
                $this->calculateLineTotal($index);
            }
        } elseif ($field === 'quantity') {
            $this->calculateLineTotal($index);
        }

        $this->calculateTotals();
    }

    public function save()
    {
        $this->validate();

        // Vérifier que l'entrepôt existe
        $warehouse = Warehouse::find($this->warehouse_id);
        
        if (!$warehouse) {
            $this->addError('warehouse_id', "L'entrepôt sélectionné n'existe pas.");
            return;
        }

        $this->checkWarehouseStock($this->productLines, $warehouse);

        // Calculer les totaux finaux
        $this->calculateTotals();
        $finalTotal = $this->subtotal - ($this->discount ?? 0);

        // passer le client en customer si il est lead
        $this->convertCustomer($this->customer_id);

        // Créer la commande
        $orderData = [
            'company_id' => $this->tenant->id,
            'customer_id' => $this->customer_id,
            'warehouse_id' => $this->warehouse_id,
            'status' => $this->status,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount ?? 0,
            'advance' => $this->advance ?? 0,
            'payment_status' => $this->payment_status,
            'total_amount' => $finalTotal,
        ];

        $order = Order::create($orderData);

        // Attacher les produits à la commande et décrémenter les stocks
        $this->attachProductsToOrder($order, $this->productLines, $warehouse);

        session()->flash('success', 'Commande créée avec succès.');
        return redirect()->route('dashboard.orders.index', [$this->tenant, $order]);
    }

    /**
     * Convertir un client en customer si il est lead
     * @param int $customerId
     * @return void
     */
    private function convertCustomer(int $customerId)
    {
        $customer = Customer::find($customerId);
        
        if ($customer->isLead()) {
            $customer->convertToCustomer();
        }
    }

    /**
     * Vérifier les stocks dans l'entrepôt sélectionné
     *
     * @param array $productLines
     * @param Warehouse $warehouse
     * @return void
     */
    private function checkWarehouseStock(array $productLines, Warehouse $warehouse)
    {
        foreach ($productLines as $index => $line) {
            if (!empty($line['product_id'])) {
                $product = Product::find($line['product_id']);
                
                if ($product) {
                    // Vérifier le stock dans l'entrepôt spécifique
                    $availableStock = $warehouse->getProductStock($product);
                    
                    if ((int) $line['quantity'] > $availableStock) {
                        $this->addError("productLines.{$index}.quantity", 
                            "La quantité demandée ({$line['quantity']}) dépasse le stock disponible ({$availableStock}) dans l'entrepôt {$warehouse->name} pour le produit {$product->name}.");
                        return;
                    }
                }
            }
        }
    }

    /**
     * Attacher les produits à la commande et décrémenter les stocks
     *
     * @param Order $order
     * @param array $productLines
     * @param Warehouse $warehouse
     * @return void
     */
    private function attachProductsToOrder(Order $order, array $productLines, Warehouse $warehouse)
    {
        foreach ($this->productLines as $line) {
            if (!empty($line['product_id'])) {
                $product = Product::find($line['product_id']);
                
                // Attacher le produit à la commande
                $order->products()->attach($line['product_id'], [
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['unit_price'],
                    'total_price' => $line['total_price'],
                ]);

                // Décrémenter le stock dans l'entrepôt spécifique
                // Cette méthode met automatiquement à jour le stock_quantity global du produit
                $warehouse->decreaseProductStock($product, (int) $line['quantity']);
            }
        }
    }

    public function render()
    {
        $customers = Customer::where('company_id', $this->tenant->id)->get();
        $warehouses = Warehouse::where('company_id', $this->tenant->id)->get();
        
        // Filtrer les produits selon l'entrepôt sélectionné
        $products = Product::where('company_id', $this->tenant->id)->get();
        
        if ($this->warehouse_id) {
            $warehouse = Warehouse::find($this->warehouse_id);
            if ($warehouse) {
                // Filtrer les produits qui ont du stock dans cet entrepôt
                $products = $products->filter(function ($product) use ($warehouse) {
                    return $warehouse->getProductStock($product) > 0;
                });
            }
        } else {
            // Si aucun entrepôt sélectionné, afficher tous les produits avec stock global > 0
            $products = $products->where('stock_quantity', '>', 0);
        }

        return view('livewire.dashboard.components.order.create-modal', [
            'statuses' => OrderStatus::cases(),
            'paymentStatuses' => PaymentStatus::cases(),
            'customers' => $customers,
            'products' => $products,
            'warehouses' => $warehouses,
        ]);
    }
}
