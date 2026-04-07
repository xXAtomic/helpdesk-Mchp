<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->date('last_maintenance_at')->nullable()->after('status');
            $table->date('next_maintenance_at')->nullable()->after('last_maintenance_at');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['last_maintenance_at', 'next_maintenance_at']);
        });
    }
};
