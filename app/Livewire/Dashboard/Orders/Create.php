<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Orders;

use App\Actions\Order\CreateAction;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Company;
use App\Enums\OrderStatus;
use App\Models\Warehouse;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Http\Requests\Order\StoreOrderRequest;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;

class Create extends Component
{
    public Company $tenant;

    public ?int $customerId = null;

    public ?int $warehouseId = null;

    public ?string $status = null;

    public ?float $discount = null;

    public ?float $advance = null;

    public ?string $paymentStatus = null;

    // Propriétés pour les produits
    public array $productLines = [];

    public float $subtotal = 0;

    public float $totalAmount = 0;

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
        $this->paymentStatus = PaymentStatus::CASH->value;

        $defaultWarehouse = $this->tenant->defaultWarehouse();
        $this->warehouseId = $defaultWarehouse ? $defaultWarehouse->id : null;

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
        $this->totalAmount = $this->subtotal - (float) ($this->discount ?? 0);
    }

    public function updatedWarehouseId()
    {
        // Mettre à jour le stock disponible pour tous les produits quand l'entrepôt change
        foreach ($this->productLines as $index => $line) {
            if (!empty($line['product_id'])) {
                $product = Product::find($line['product_id']);
                
                if ($product && $this->warehouseId) {
                    $warehouse = Warehouse::find($this->warehouseId);
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
                if ($this->warehouseId) {
                    $warehouse = Warehouse::find($this->warehouseId);
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

    public function save(CreateAction $action)
    {
        $validated = $this->validate();
        $validated['company_id'] = $this->tenant->id;

        // Vérifier que l'entrepôt existe
        $warehouse = Warehouse::findOrFail($this->warehouseId);
        
        /* if (!$warehouse) {
            $this->addError('warehouseId', "L'entrepôt sélectionné n'existe pas.");
            return;
        } */

        $this->checkWarehouseStock($this->productLines, $warehouse);

        // Calculer les totaux finaux
        $this->calculateTotals();
        $finalTotal = $this->subtotal - ($this->discount ?? 0);
        
        $validated['subtotal'] = $this->subtotal;
        $validated['discount'] = $this->discount;
        $validated['advance'] = $this->advance;
        $validated['total'] = $finalTotal;

        // Passer le client en customer si il est lead
        $this->convertCustomer($this->customerId);

        // Créer la commande
        $order = $action->handle($validated, $this->productLines);

        Cache::forget("dashboard-last-orders-{$this->tenant->id}");

        $this->dispatch('order-created');
        $this->dispatch('notify', 'Commande créée avec succès !');
        $this->dispatch('close-modal', id: 'create-order');
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

    #[On('customer-created')]
    public function refreshCustomers()
    {
        // Sélectionner le dernier client créer
    }

    public function render()
    {
        $customers = Customer::where('company_id', $this->tenant->id)->get();
        $warehouses = Warehouse::where('company_id', $this->tenant->id)->get();
        
        // Filtrer les produits selon l'entrepôt sélectionné
        $products = Product::where('company_id', $this->tenant->id)->get();
        
        if ($this->warehouseId) {
            $warehouse = Warehouse::find($this->warehouseId);

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

        // dd(PaymentStatus::cases());

        return view('livewire.dashboard.orders.create', [
            'statuses' => OrderStatus::cases(),
            'paymentStatuses' => PaymentStatus::cases(),
            'customers' => $customers,
            'products' => $products,
            'warehouses' => $warehouses,
        ]);
    }
}
