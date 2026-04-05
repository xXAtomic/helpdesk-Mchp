<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\TicketController as UserTicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});

// Middleware de Autenticación Principal
Route::middleware(['auth'])->group(function () {

    // PORTAL DE REDIRECCIÓN -> Redirige al Dashboard correcto según el ROL
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isBoss()) {
            return redirect()->route('boss.dashboard');
        }

        if ($user->isTechnician()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.tickets.index');
    })->name('dashboard');

    // Rutas de Usuario Común
    Route::prefix('user')->name('user.')->group(function () {
        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/', [UserTicketController::class, 'index'])->name('index');
            Route::get('/create', [UserTicketController::class, 'create'])->name('create');
            Route::post('/', [UserTicketController::class, 'store'])->name('store');
            Route::get('/{ticket}', [UserTicketController::class, 'show'])->name('show');
            Route::post('/{ticket}/reply', [UserTicketController::class, 'reply'])->name('reply');
        });

        // Base de Conocimientos (Solo Lectura)
        Route::get('/knowledge', function () {
            $articles = \App\Models\KnowledgeBaseArticle::where('is_published', true)->get();
            return view('user.knowledge.index', compact('articles'));
        })->name('knowledge.index');
    });

    // PANEL DE JEFE (Reportes)
    Route::middleware(['role:boss,supervisor,admin'])->prefix('boss')->name('boss.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Boss\DashboardController::class, 'index'])->name('dashboard');
    });

    // PANEL ADMINISTRATIVO / TÉCNICO
    Route::middleware(['role:admin,technician'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Tickets Admin
        Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
        Route::post('/tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('tickets.reply');
        Route::post('/tickets/{ticket}/assign', [AdminTicketController::class, 'assign'])->name('tickets.assign');
        Route::post('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.status');

        // Inventario (Equipos) -> Admin Puede Registrar
        Route::get('/assets', function () {
            return "Módulo de Inventario en Construcción - Lista de Activos";
        })->name('assets.index');
        Route::post('/assets', function () {
            return "Registrando Equipo...";
        })->name('assets.store');

        // Base de Conocimientos (Admin CRUD)
        Route::get('/knowledge', function () {
            return "Módulo de Conocimientos - Admin CRUD";
        })->name('knowledge.index');
    });
});

require __DIR__ . '/auth.php';

// --- RUTAS TEMPORALES DE EMERGENCIA ---

// 1. Forzar Logout por URL (Entra a tickets.crisadones.com/force-logout)
Route::get('/force-logout', function () {
    Auth::logout();
    
    // Invalida la sesión y regenera el token CSRF para mayor seguridad
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login')->with('success', 'Sesión cerrada correctamente');
});

// 2. Ver por qué no tengo permisos (Entra a tickets.crisadones.com/debug-role)
Route::get('/debug-role', function () {
    $user = auth()->user();
    if (!$user)
        return "No estás logueado en el sistema";

    // Forzamos la carga del rol para ver si existe
    $rol = \App\Models\Role::find($user->role_id);

    return [
        'tu_email' => $user->email,
        'tu_rol_id_en_base_de_datos' => $user->role_id,
        'nombre_del_rol' => $rol ? $rol->name : 'ROL NO ENCONTRADO',
        'slug_del_rol' => $rol ? $rol->slug : 'SIN SLUG',
        '¿El sistema te ve como Admin?' => $user->isAdmin() ? 'SI' : 'NO',
    ];
})->middleware('auth');

// --- FIN RUTAS DE EMERGENCIA ---
