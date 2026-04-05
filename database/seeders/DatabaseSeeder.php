<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
<<<<<<< HEAD
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\Department;
use App\Models\TicketCategory;
=======
use App\Models\Priority;
use App\Models\Status;
use App\Models\Department;
use App\Models\Category;
>>>>>>> origin/servidor-maraton-ayer

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< HEAD
        // 1. Crear Roles (Corregidos slugs)
        $roles = [
            ['name' => 'Administrador', 'slug' => 'admin', 'description' => 'Control total'],
            ['name' => 'Jefe / Supervisor', 'slug' => 'supervisor', 'description' => 'Visualización de reportes y métricas'],
=======
        // 1. Crear Roles
        $roles = [
            ['name' => 'Administrador', 'slug' => 'admin', 'description' => 'Control total'],
            ['name' => 'Supervisor', 'slug' => 'supervisor', 'description' => 'Supervisa técnicos y métricas'],
>>>>>>> origin/servidor-maraton-ayer
            ['name' => 'Técnico', 'slug' => 'technician', 'description' => 'Resuelve tickets y gestiona inventario'],
            ['name' => 'Usuario', 'slug' => 'user', 'description' => 'Usuario final que reporta incidencias'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }

<<<<<<< HEAD
        // 2. Roles base
        $adminRole = Role::where('slug', 'admin')->first();
        $bossRole = Role::where('slug', 'supervisor')->first();
        $techRole = Role::where('slug', 'technician')->first();
        $userRole = Role::where('slug', 'user')->first();

        // 3. Crear Usuarios Base (Corregidos nombres y slugs)
        // Admin: cris adones
        User::firstOrCreate(
            ['email' => 'soporte.crisadones@gmail.com'],
            [
                'name' => 'Administrador Soporte',
=======
        // 2. Crear Usuarios Base
        $adminRole = Role::where('slug', 'admin')->first();
        $techRole = Role::where('slug', 'technician')->first();
        $userRole = Role::where('slug', 'user')->first();

        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
>>>>>>> origin/servidor-maraton-ayer
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

<<<<<<< HEAD
        // Normal User: atomic
        User::firstOrCreate(
            ['email' => 'cris.adones@gmail.com'],
            [
                'name' => 'Usuario Normal',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
            ]
        );

=======
>>>>>>> origin/servidor-maraton-ayer
        User::firstOrCreate(
            ['email' => 'tecnico@admin.com'],
            [
                'name' => 'Técnico Soporte',
                'password' => Hash::make('password'),
                'role_id' => $techRole->id,
            ]
        );

<<<<<<< HEAD
        // 4. Crear Prioridades
=======
        User::firstOrCreate(
            ['email' => 'usuario@admin.com'],
            [
                'name' => 'Usuario Común',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
            ]
        );

        // 3. Crear Prioridades
>>>>>>> origin/servidor-maraton-ayer
        $priorities = [
            ['name' => 'Baja', 'slug' => 'baja', 'level' => 1, 'color' => '#10B981'],
            ['name' => 'Media', 'slug' => 'media', 'level' => 2, 'color' => '#F59E0B'],
            ['name' => 'Alta', 'slug' => 'alta', 'level' => 3, 'color' => '#EF4444'],
            ['name' => 'Crítica', 'slug' => 'critica', 'level' => 4, 'color' => '#7F1D1D'],
        ];

        foreach ($priorities as $priority) {
<<<<<<< HEAD
            TicketPriority::firstOrCreate(['slug' => $priority['slug']], $priority);
        }

        // 5. Crear Estados
        $statuses = [
            ['name' => 'Abierto', 'slug' => 'abierto', 'is_closed' => false, 'color' => '#3B82F6'],
            ['name' => 'En Progreso', 'slug' => 'en-progreso', 'is_closed' => false, 'color' => '#8B5CF6'],
=======
            Priority::firstOrCreate(['slug' => $priority['slug']], $priority);
        }

        // 4. Crear Estados
        $statuses = [
            ['name' => 'Abierto', 'slug' => 'abierto', 'is_closed' => false, 'color' => '#3B82F6'],
            ['name' => 'En Progreso', 'slug' => 'progreso', 'is_closed' => false, 'color' => '#8B5CF6'],
>>>>>>> origin/servidor-maraton-ayer
            ['name' => 'Pendiente', 'slug' => 'pendiente', 'is_closed' => false, 'color' => '#F59E0B'],
            ['name' => 'Resuelto', 'slug' => 'resuelto', 'is_closed' => true, 'color' => '#10B981'],
            ['name' => 'Cerrado', 'slug' => 'cerrado', 'is_closed' => true, 'color' => '#6B7280'],
        ];

        foreach ($statuses as $status) {
<<<<<<< HEAD
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
=======
            Status::firstOrCreate(['slug' => $status['slug']], $status);
        }

        // 5. Crear Categorías
        $categories = [
            ['name' => 'Incidencia', 'slug' => 'incidencia', 'color' => '#F43F5E'],
            ['name' => 'Requerimiento', 'slug' => 'requerimiento', 'color' => '#3B82F6'],
            ['name' => 'Mantenimiento', 'slug' => 'mantenimiento', 'color' => '#10B981'],
            ['name' => 'Otros', 'slug' => 'otros', 'color' => '#8B5CF6'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
>>>>>>> origin/servidor-maraton-ayer
        }
    }
}
