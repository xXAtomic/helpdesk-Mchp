<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Corregimos de 'equipments' a 'assets' que es el nombre real de la tabla
        Schema::table('assets', function (Blueprint $table) {
            $table->decimal('purchase_cost', 15, 2)->default(0)->after('status');
        });

        Schema::table('supplies', function (Blueprint $table) {
            $table->decimal('unit_cost', 15, 2)->default(0)->after('stock');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('purchase_cost');
        });

        Schema::table('supplies', function (Blueprint $table) {
            $table->dropColumn('unit_cost');
        });
    }
};
