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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // Ej: Laptop Dell Latitude
            $table->string('brand');            // Ej: Dell
            $table->string('model')->nullable();
            $table->string('serial_number')->unique();
            $table->string('inventory_code')->unique(); // Código interno
            $table->string('type');             // Laptop, Impresora, etc.
            $table->string('status')->default('Operativo'); // Operativo...
            $table->string('location')->nullable(); 
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
