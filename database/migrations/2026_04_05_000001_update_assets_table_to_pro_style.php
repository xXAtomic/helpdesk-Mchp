<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Renombrar 'code' a 'asset_tag' para coincidir con el diseño Pro
            if (Schema::hasColumn('assets', 'code') && !Schema::hasColumn('assets', 'asset_tag')) {
                $table->renameColumn('code', 'asset_tag');
            }
            
            // Añadir 'location' si no existe
            if (!Schema::hasColumn('assets', 'location')) {
                $table->string('location')->nullable()->after('status');
            }

            // Asegurar que 'model' existe
            if (!Schema::hasColumn('assets', 'model')) {
                $table->string('model')->nullable()->after('brand');
            }
            
            // Quitar 'name' si es redundante (el modelo lo cubre)
            if (Schema::hasColumn('assets', 'name')) {
                $table->string('name')->nullable()->change(); 
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            if (Schema::hasColumn('assets', 'asset_tag')) {
                $table->renameColumn('asset_tag', 'code');
            }
            $table->dropColumn('location');
        });
    }
};
