<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');

            $table->string('position')->nullable(); // Poste/emploi
            $table->string('department')->nullable(); // Département
            $table->date('hire_date')->nullable(); // Date d'embauche
            $table->boolean('active')->default(true); // Employé actif ou non

            $table->timestamps();
            $table->softDeletes();

            // Un utilisateur ne peut être employé qu'une seule fois par entreprise
            $table->unique(['user_id', 'company_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
