<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalDocument;

class LegalDocumentSeeder extends Seeder
{
    public function run(): void
    {
        LegalDocument::updateOrCreate(
            ['slug' => 'recibimiento-devolucion-iasd'],
            [
                'title' => 'Término Recibimiento y Devolución IASD',
                'content' => 'Template para IASD',
                'version' => '1.0',
                'is_active' => true,
                'requires_asset' => true,
                'entity' => 'IASD'
            ]
        );

        LegalDocument::updateOrCreate(
            ['slug' => 'recibimiento-devolucion-fesdg'],
            [
                'title' => 'Término Recibimiento y Devolución FESDG',
                'content' => 'Template para FESDG',
                'version' => '1.0',
                'is_active' => true,
                'requires_asset' => true,
                'entity' => 'FESDG'
            ]
        );

        // NUEVOS DOCUMENTOS DE PRÉSTAMO
        LegalDocument::updateOrCreate(
            ['slug' => 'responsabilidad-prestamo-iasd'],
            [
                'title' => 'Responsabilidad de Préstamo IASD',
                'content' => 'Término de préstamo para Misión Chilena del Pacífico',
                'version' => '1.0',
                'is_active' => true,
                'requires_asset' => true,
                'entity' => 'IASD'
            ]
        );

        LegalDocument::updateOrCreate(
            ['slug' => 'responsabilidad-prestamo-fesdg'],
            [
                'title' => 'Responsabilidad de Préstamo FESDG',
                'content' => 'Término de préstamo para Fundación Educacional Sanders de Groot',
                'version' => '1.0',
                'is_active' => true,
                'requires_asset' => true,
                'entity' => 'FESDG'
            ]
        );

        // NUEVOS DOCUMENTOS DE COMPROMISO Y CONCIENCIA
        LegalDocument::updateOrCreate(
            ['slug' => 'compromiso-conciencia-iasd'],
            [
                'title' => 'Compromiso y Conciencia IASD',
                'content' => 'Término de responsabilidad y política de seguridad IASD',
                'version' => '1.0',
                'is_active' => true,
                'requires_asset' => false,
                'entity' => 'IASD'
            ]
        );

        LegalDocument::updateOrCreate(
            ['slug' => 'compromiso-conciencia-fesdg'],
            [
                'title' => 'Compromiso y Conciencia FESDG',
                'content' => 'Término de responsabilidad y política de seguridad FESDG',
                'version' => '1.0',
                'is_active' => true,
                'requires_asset' => false,
                'entity' => 'FESDG'
            ]
        );

        // NUEVOS DOCUMENTOS DE USO EXTERNO / SALVOCONDUCTO
        LegalDocument::updateOrCreate(
            ['slug' => 'autorizacion-uso-externo-iasd'],
            [
                'title' => 'Autorización Uso Externo IASD',
                'content' => 'Salvoconducto de traslado y permiso de uso fuera de la institución IASD',
                'version' => '1.0',
                'is_active' => true,
                'requires_asset' => true,
                'entity' => 'IASD'
            ]
        );

        LegalDocument::updateOrCreate(
            ['slug' => 'autorizacion-uso-externo-fesdg'],
            [
                'title' => 'Autorización Uso Externo FESDG',
                'content' => 'Salvoconducto de traslado y permiso de uso fuera de la institución FESDG',
                'version' => '1.0',
                'is_active' => true,
                'requires_asset' => true,
                'entity' => 'FESDG'
            ]
        );
    }



}
