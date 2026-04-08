<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('type'); // TONER, PERIPHERAL, CABLE, etc.
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(5); // Umbral de alerta
            $table->string('location')->nullable();
            $table->timestamps();
        });

        Schema::create('supply_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supply_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained(); // Usuario que recibe
            $table->foreignId('admin_id')->constrained('users'); // Administrador que entrega
            $table->string('equipment_tag')->nullable(); // Si se asocia a un equipo específico
            $table->integer('quantity');
            $table->enum('action', ['RESTOCK', 'CONSUMPTION', 'LOAN', 'RETURN'])->default('CONSUMPTION');
            $table->enum('status', ['COMPLETED', 'PENDING_RETURN', 'RETURNED'])->default('COMPLETED');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supply_logs');
        Schema::dropIfExists('supplies');
    }
};
