<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_quotation', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');

            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Index pour optimiser les recherches
            $table->index(['quotation_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_quotation');
    }
};
