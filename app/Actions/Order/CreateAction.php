<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

final class CreateAction
{
    /**
     * Création d'une commande et des produits associés deduits de l'emplacement sélectionné
     *
     * @param array $data
     * @param array $products Les lignes / items produits associés à la commande
     * @return Order
     */
    public function handle(array $data, array $products): Order
    {
        return DB::transaction(function () use ($data, $products) {
            $order = Order::create([
                'company_id' => $data['company_id'],
                'customer_id' => $data['customerId'],
                'warehouse_id' => $data['warehouseId'],
                'status' => $data['status'],
                'subtotal' => $data['subtotal'],
                'discount' => $data['discount'],
                'advance' => $data['advance'],
                'payment_status' => $data['paymentStatus'],
                'total_amount' => $data['total'],
            ]);

            $warehouse = Warehouse::findOrFail($data['warehouseId']);

            // Attacher les produits à la commande et décrémenter les stocks
            $this->attachProductsToOrder($order, $products, $warehouse);

            return $order;
        });
    }

    /**
     * Attacher les produits à la commande et décrémenter les stocks
     *
     * @param Order $order
     * @param array $productLines
     * @param Warehouse $warehouse L'entrepôt d'ou sera pris les produits
     * @return void
     */
    private function attachProductsToOrder(Order $order, array $productLines, Warehouse $warehouse)
    {
        foreach ($productLines as $line) {
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
}
