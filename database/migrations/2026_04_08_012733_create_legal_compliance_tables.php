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
        // 1. Plantillas de Documentos Legales
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Ej: Responsabilidad de Equipos
            $table->string('slug')->unique();
            $table->text('content'); // Contenido en Markdown o HTML
            $table->string('version')->default('1.0');
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_asset')->default(false); // Si aplica específicamente a un equipo
            $table->timestamps();
        });

        // 2. Registro de Firmas / Aceptaciones
        Schema::create('document_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('legal_document_id')->constrained('legal_documents')->onDelete('cascade');
            $table->foreignId('asset_id')->nullable()->constrained('assets')->onDelete('set null'); // Opcional, si es por equipo
            
            $table->timestamp('signed_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_accepted')->default(false);
            
            // Metadatos adicionales (Ej: nombre completo al momento de firmar)
            $table->string('signature_token')->unique(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_signatures');
        Schema::dropIfExists('legal_documents');
    }
};
