<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_deflections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('title')->nullable(); // El título que el usuario estaba escribiendo
            $table->integer('article_id')->nullable(); // El ID del manual que lo ayudó (si aplica)
            $table->enum('method', ['ARTICLE', 'AI_BOT'])->default('ARTICLE');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_deflections');
    }
};
