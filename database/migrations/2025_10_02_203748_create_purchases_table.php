<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');

            $table->decimal('amount', 15, 2);
            $table->text('details')->nullable(); // Détails libres (explications, référence facture, etc.)
            $table->date('purchased_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index pour optimiser les recherches
            $table->index(['company_id', 'supplier_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
