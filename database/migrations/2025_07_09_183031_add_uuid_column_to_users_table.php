<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'uuid')) {
                $table->uuid()->after('id')->nullable()->unique();
            }
        });

        if (App::environment('local')) {
            \App\Models\User::all()->each(function (\App\Models\User $user) {
                $user->uuid = \Illuminate\Support\Str::uuid();
                $user->save();
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['uuid']);
        });
    }
};
