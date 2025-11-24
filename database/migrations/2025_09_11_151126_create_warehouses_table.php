<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('location')->nullable();
            $table->boolean('default')->default(false);
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['company_id', 'default']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
