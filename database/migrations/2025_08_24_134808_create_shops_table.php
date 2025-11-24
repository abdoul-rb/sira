<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('slug')->unique(); // URL personnalisée (ex: monentreprise.crm.com/ma-boutique)
            $table->string('logo_path')->nullable();
            $table->text('description')->nullable();

            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
