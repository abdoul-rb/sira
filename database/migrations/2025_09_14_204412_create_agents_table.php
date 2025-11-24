<?php

declare(strict_types=1);

use App\Enums\TitleEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();

            $table->foreignId('company_id')->constrained()->onDelete('cascade');

            $table->enum('title', TitleEnum::values())->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone_number')->nullable();
            $table->text('localization')->nullable();
            $table->boolean('active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Index pour optimiser les recherches
            $table->index(['company_id', 'phone_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
