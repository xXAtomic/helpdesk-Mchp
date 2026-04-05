<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\Department;
use App\Models\TicketCategory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Roles
        $roles = [
            ['name' => 'Administrador', 'slug' => 'admin', 'description' => 'Control total'],
            ['name' => 'Jefe / Supervisor', 'slug' => 'supervisor', 'description' => 'Visualización de reportes y métricas'],
            ['name' => 'Técnico', 'slug' => 'technician', 'description' => 'Resuelve tickets y gestiona inventario'],
            ['name' => 'Usuario', 'slug' => 'user', 'description' => 'Usuario final que reporta incidencias'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }

        // 2. Roles base
        $adminRole = Role::where('slug', 'admin')->first();
        $userRole = Role::where('slug', 'user')->first();
        $techRole = Role::where('slug', 'technician')->first();

        // 3. Crear Usuarios Base
        User::firstOrCreate(
            ['email' => 'soporte.crisadones@gmail.com'],
            [
                'name' => 'Administrador Soporte',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'cris.adones@gmail.com'],
            [
                'name' => 'Usuario Normal',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'tecnico@admin.com'],
            [
                'name' => 'Técnico Soporte',
                'password' => Hash::make('password'),
                'role_id' => $techRole->id,
            ]
        );

        // 4. Crear Prioridades
        $priorities = [
            ['name' => 'Baja', 'slug' => 'baja', 'level' => 1, 'color' => '#10B981'],
            ['name' => 'Media', 'slug' => 'media', 'level' => 2, 'color' => '#F59E0B'],
            ['name' => 'Alta', 'slug' => 'alta', 'level' => 3, 'color' => '#EF4444'],
            ['name' => 'Crítica', 'slug' => 'critica', 'level' => 4, 'color' => '#7F1D1D'],
        ];

        foreach ($priorities as $priority) {
            TicketPriority::firstOrCreate(['slug' => $priority['slug']], $priority);
        }

        // 5. Crear Estados
        $statuses = [
            ['name' => 'Abierto', 'slug' => 'abierto', 'is_closed' => false, 'color' => '#3B82F6'],
            ['name' => 'En Progreso', 'slug' => 'en-progreso', 'is_closed' => false, 'color' => '#8B5CF6'],
            ['name' => 'Pendiente', 'slug' => 'pendiente', 'is_closed' => false, 'color' => '#F59E0B'],
            ['name' => 'Resuelto', 'slug' => 'resuelto', 'is_closed' => true, 'color' => '#10B981'],
            ['name' => 'Cerrado', 'slug' => 'cerrado', 'is_closed' => true, 'color' => '#6B7280'],
        ];

        foreach ($statuses as $status) {
            TicketStatus::firstOrCreate(['slug' => $status['slug']], $status);
        }

        // 6. Departamentos Base
        $departments = [
            ['name' => 'Soporte Técnico', 'description' => 'Ayuda con equipos y software'],
            ['name' => 'Redes y Servidores', 'description' => 'Problemas de conectividad e infraestructura'],
            ['name' => 'Desarrollo', 'description' => 'Sistemas web y bases de datos'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept['name']], $dept);
        }

        // 7. Categorías Base
        $categories = [
            ['name' => 'Hardware', 'slug' => 'hardware', 'color' => '#475569'],
            ['name' => 'Software', 'slug' => 'software', 'color' => '#0EA5E9'],
            ['name' => 'Incidencia', 'slug' => 'incidencia', 'color' => '#F43F5E'],
            ['name' => 'Requerimiento', 'slug' => 'requerimiento', 'color' => '#8B5CF6'],
        ];

        foreach ($categories as $cat) {
            TicketCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
