<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PaymentStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('discount', 10, 2)->default(0)->after('tax_amount');
            $table->decimal('advance', 10, 2)->default(0)->after('discount');
            $table->enum('payment_status', PaymentStatus::values())->nullable()->after('advance');
            
            $table->renameColumn('confirmed_at', 'paid_at');
            
            $table->dropColumn([
                'shipping_cost',
                'shipping_address',
                'billing_address',
                'notes',
                'shipped_at'
            ]);

            $table->dropForeign(['quotation_id']);
            $table->dropColumn('quotation_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_cost', 10, 2)->nullable()->after('tax_amount');
            $table->text('shipping_address')->nullable()->after('total_amount');
            $table->text('billing_address')->nullable()->after('shipping_address');
            $table->text('notes')->nullable()->after('billing_address');
            $table->timestamp('shipped_at')->nullable()->after('delivered_at');
            
            $table->renameColumn('paid_at', 'confirmed_at');
            
            $table->dropColumn([
                'discount',
                'advance',
                'payment_status'
            ]);

            $table->foreignId('quotation_id')->nullable()->constrained()->onDelete('set null');
        });
    }
};