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
    }

}
