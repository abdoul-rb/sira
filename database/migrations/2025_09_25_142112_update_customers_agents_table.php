<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TitleEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn(['title']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['title']);
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->enum('title', TitleEnum::values())->nullable();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->enum('title', TitleEnum::values())->nullable();
        });
    }
};
