<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->after('country', function (Blueprint $table) {
                $table->string('facebook_url')->nullable();
                $table->string('instagram_url')->nullable();
                $table->string('tiktok_url')->nullable();
            });

            $table->dropUnique('companies_email_unique');
            $table->dropColumn(['email', 'phone_number', 'website', 'address', 'city']);
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['facebook_url', 'instagram_url', 'tiktok_url']);

            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
        });
    }
};
