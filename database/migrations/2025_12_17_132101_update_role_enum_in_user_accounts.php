<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_accounts', function (Blueprint $table) {
            // Modify enum to include 'agent'
            $table->enum('role', ['client', 'washer', 'admin', 'agent'])->default('client')->change();
        });
    }

    public function down(): void
    {
        Schema::table('user_accounts', function (Blueprint $table) {
            $table->enum('role', ['client', 'washer', 'admin'])->default('client')->change();
        });
    }
};
