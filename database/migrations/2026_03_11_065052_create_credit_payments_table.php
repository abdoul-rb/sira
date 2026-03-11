<?php

declare(strict_types=1);

use App\Enums\PaymentMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('credit_id')->constrained()->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', PaymentMethod::values())->default(PaymentMethod::CASH);
            $table->timestamp('paid_at');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();

            $table->index(['credit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_payments');
    }
};
