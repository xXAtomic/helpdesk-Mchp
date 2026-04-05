<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Department;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Roles
        $roles = [
            ['name' => 'Administrador', 'slug' => 'admin', 'description' => 'Control total'],
            ['name' => 'Supervisor', 'slug' => 'supervisor', 'description' => 'Supervisa técnicos y métricas'],
            ['name' => 'Técnico', 'slug' => 'technician', 'description' => 'Resuelve tickets y gestiona inventario'],
            ['name' => 'Usuario', 'slug' => 'user', 'description' => 'Usuario final que reporta incidencias'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }

        // 2. Crear Usuarios Base
        $adminRole = Role::where('slug', 'admin')->first();
        $techRole = Role::where('slug', 'technician')->first();
        $userRole = Role::where('slug', 'user')->first();

        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
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

        User::firstOrCreate(
            ['email' => 'usuario@admin.com'],
            [
                'name' => 'Usuario Común',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
            ]
        );

        // 3. Crear Prioridades
        $priorities = [
            ['name' => 'Baja', 'slug' => 'baja', 'level' => 1, 'color' => '#10B981'],
            ['name' => 'Media', 'slug' => 'media', 'level' => 2, 'color' => '#F59E0B'],
            ['name' => 'Alta', 'slug' => 'alta', 'level' => 3, 'color' => '#EF4444'],
            ['name' => 'Crítica', 'slug' => 'critica', 'level' => 4, 'color' => '#7F1D1D'],
        ];

        foreach ($priorities as $priority) {
            Priority::firstOrCreate(['slug' => $priority['slug']], $priority);
        }

        // 4. Crear Estados
        $statuses = [
            ['name' => 'Abierto', 'slug' => 'abierto', 'is_closed' => false, 'color' => '#3B82F6'],
            ['name' => 'En Progreso', 'slug' => 'progreso', 'is_closed' => false, 'color' => '#8B5CF6'],
            ['name' => 'Pendiente', 'slug' => 'pendiente', 'is_closed' => false, 'color' => '#F59E0B'],
            ['name' => 'Resuelto', 'slug' => 'resuelto', 'is_closed' => true, 'color' => '#10B981'],
            ['name' => 'Cerrado', 'slug' => 'cerrado', 'is_closed' => true, 'color' => '#6B7280'],
        ];

        foreach ($statuses as $status) {
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
        }
    }
}
