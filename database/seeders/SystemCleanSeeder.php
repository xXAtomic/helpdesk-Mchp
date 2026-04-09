<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SystemCleanSeeder extends Seeder
{
    /**
     * Limpia todas las tablas de tickets e inventario para un inicio fresco.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = [
            'ticket_attachments',
            'ticket_comments',
            'tickets',
            'maintenances',
            'asset_logs',
            'assets',
            'asset_types',
            'categories',
            'brands',
            'suppliers',
            'document_signatures',
            'supply_logs',
            'supplies'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->command->info("Tabla limidada: $table");
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('GRAVITY: Sistema reseteado a cero (Tickets e Inventario).');
    }
}
