<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asset_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // El autor del cambio
            $table->string('action'); // 'CREATE', 'UPDATE', 'DELETE', 'ASSIGN'
            $table->json('old_data')->nullable(); // Foto del estado anterior
            $table->json('new_data')->nullable(); // Foto del estado nuevo
            $table->text('details')->nullable(); // Comentario extra
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_logs');
    }
};
