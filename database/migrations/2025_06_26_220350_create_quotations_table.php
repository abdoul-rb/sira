<?php

use App\Enums\QuotationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference')->unique(); // Numéro de devis unique

            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');

            $table->enum('status', QuotationStatus::values()); // Enum: draft, sent, accepted, rejected, expired
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->date('valid_until')->nullable(); // Date de validité du devis
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index pour optimiser les recherches
            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'customer_id']);
            $table->index('reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
