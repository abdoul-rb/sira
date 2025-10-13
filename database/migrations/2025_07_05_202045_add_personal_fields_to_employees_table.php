<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('firstname')->nullable()->after('company_id');
            $table->string('lastname')->nullable()->after('firstname');
            $table->string('phone_number')->nullable()->after('position');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['firstname', 'lastname', 'phone_number']);
        });
    }
};
