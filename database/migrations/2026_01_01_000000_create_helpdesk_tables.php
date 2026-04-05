<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
<<<<<<< HEAD
        // 1. Roles (Estructura base de permisos)
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique(); // admin, supervisor, technician, user
=======
        // 1. Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
>>>>>>> origin/servidor-maraton-ayer
            $table->string('description')->nullable();
            $table->timestamps();
        });

<<<<<<< HEAD
        // 2. Users (Estructura base)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Modificar Users con campos extras (esto se hacía en el mismo archivo antes)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->default(4)->constrained('roles')->onDelete('cascade');
=======
        // 2. MODIFICAR Users (En lugar de crearla)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->index()->default(4)->constrained('roles')->onDelete('cascade');
>>>>>>> origin/servidor-maraton-ayer
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });

        // 3. Departments
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // 4. Ticket Categories
<<<<<<< HEAD
        Schema::create('ticket_categories', function (Blueprint $table) {
=======
        Schema::create('categories', function (Blueprint $table) {
>>>>>>> origin/servidor-maraton-ayer
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color', 7)->default('#3b82f6');
            $table->timestamps();
        });

        // 5. Ticket Priorities
<<<<<<< HEAD
        Schema::create('ticket_priorities', function (Blueprint $table) {
=======
        Schema::create('priorities', function (Blueprint $table) {
>>>>>>> origin/servidor-maraton-ayer
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color', 7)->default('#3b82f6');
            $table->integer('level')->default(1);
            $table->timestamps();
        });

        // 6. Ticket Statuses
<<<<<<< HEAD
        Schema::create('ticket_statuses', function (Blueprint $table) {
=======
        Schema::create('statuses', function (Blueprint $table) {
>>>>>>> origin/servidor-maraton-ayer
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color', 7)->default('#3b82f6');
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });

        // 7. Assets (Inventario mejorado)
<<<<<<< HEAD
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique(); // Asset Tag
=======
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
>>>>>>> origin/servidor-maraton-ayer
            $table->string('type');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('status')->default('active');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });

        // 8. Tickets (Conexión total)
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('title');
            $table->text('description');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
<<<<<<< HEAD
            $table->foreignId('category_id')->nullable()->constrained('ticket_categories')->onDelete('set null');
            $table->foreignId('priority_id')->nullable()->constrained('ticket_priorities')->onDelete('set null');
            $table->foreignId('status_id')->nullable()->constrained('ticket_statuses')->onDelete('set null');
            $table->foreignId('asset_id')->nullable()->constrained('assets')->onDelete('set null');
=======
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('priority_id')->nullable()->constrained('priorities')->onDelete('set null');
            $table->foreignId('status_id')->nullable()->constrained('statuses')->onDelete('set null');
            $table->foreignId('asset_id')->nullable()->constrained('equipment')->onDelete('set null');
>>>>>>> origin/servidor-maraton-ayer
            $table->timestamp('due_date')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

<<<<<<< HEAD
        // 9. Ticket Responses (Mejor que "replies")
        Schema::create('ticket_responses', function (Blueprint $table) {
=======
        // 9. Ticket Responses
        Schema::create('ticket_resplies', function (Blueprint $table) {
>>>>>>> origin/servidor-maraton-ayer
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('body');
            $table->boolean('is_internal')->default(false);
            $table->timestamps();
        });

        // 10. Ticket Attachments
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->nullable()->constrained('tickets')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->integer('file_size');
            $table->timestamps();
        });

<<<<<<< HEAD
        // 11. Knowledge Manuals (Para el modulo de conocimiento)
=======
        // 11. Knowledge Manuals
>>>>>>> origin/servidor-maraton-ayer
        Schema::create('knowledge_manuals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('category')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_manuals');
        Schema::dropIfExists('ticket_attachments');
<<<<<<< HEAD
        Schema::dropIfExists('ticket_responses');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('ticket_statuses');
        Schema::dropIfExists('ticket_priorities');
        Schema::dropIfExists('ticket_categories');
=======
        Schema::dropIfExists('ticket_resplies');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('equipment');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('priorities');
        Schema::dropIfExists('categories');
>>>>>>> origin/servidor-maraton-ayer
        Schema::dropIfExists('departments');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
