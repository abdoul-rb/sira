<?php

declare(strict_types=1);

use App\Enums\CreditStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            $table->date('due_date')->nullable();
            $table->enum('status', CreditStatus::values())->default(CreditStatus::PENDING);

            $table->timestamps();

            $table->index(['order_id']);
            $table->index(['company_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
