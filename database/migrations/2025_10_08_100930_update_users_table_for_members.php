<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->renameColumn('firstname', 'name');
            $table->dropColumn(['company_id', 'lastname', 'phone_number']);

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('id')->constrained()->onDelete('set null');

            $table->string('firstname')->nullable()->after('company_id');
            $table->string('lastname')->nullable()->after('firstname');
            $table->string('phone_number')->nullable()->after('email');

            $table->dropSoftDeletes();
        });
    }
};
