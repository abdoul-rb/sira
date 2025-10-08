<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('employees', 'members');

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['position', 'department', 'hire_date', 'active']);
        });
    }

    public function down(): void
    {
        Schema::rename('members', 'employees');

        Schema::table('employees', function (Blueprint $table) {
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->date('hire_date')->nullable();
            $table->boolean('active')->default(true);
        });
    }
};
