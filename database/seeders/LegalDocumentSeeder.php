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
    }
}
