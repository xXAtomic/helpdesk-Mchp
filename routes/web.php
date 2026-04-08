<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\KnowledgeBaseController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Boss\BossDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\AuthController;

// --- 🔓 1. RUTAS PÚBLICAS (LOGIN) ---
Route::get('/', function () { return redirect()->route('login'); });
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- 🔒 2. RUTAS PROTEGIDAS (REQUIEREN LOGIN) ---
Route::middleware(['auth'])->group(function () {

    // --- 👨‍💻 PANEL DE ADMINISTRADOR / TÉCNICO ---
    Route::prefix('admin')->group(function () {
        
        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // GESTIÓN DE TICKETS (RESOURCE)
        Route::resource('tickets', AdminTicketController::class)->names('admin.tickets');
        Route::post('/tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('admin.tickets.reply');
        Route::post('/tickets/{ticket}/assign', [AdminTicketController::class, 'assign'])->name('admin.tickets.assign');
        Route::post('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('admin.tickets.status');

        // INVENTARIO DE EQUIPOS 🖥️ ✅
        Route::prefix('inventory')->group(function () {
            Route::get('/', [EquipmentController::class, 'index'])->name('admin.inventory.index');
            Route::get('/create', [EquipmentController::class, 'create'])->name('admin.inventory.create');
            Route::post('/', [EquipmentController::class, 'store'])->name('admin.inventory.store');
            Route::get('/{id}', [EquipmentController::class, 'show'])->name('admin.inventory.show');
            Route::get('/{id}/edit', [EquipmentController::class, 'edit'])->name('admin.inventory.edit');
            Route::put('/{id}', [EquipmentController::class, 'update'])->name('admin.inventory.update');
            Route::delete('/{id}', [EquipmentController::class, 'destroy'])->name('admin.inventory.destroy');
            Route::post('/{id}/maintenance', [EquipmentController::class, 'storeMaintenance'])->name('admin.inventory.maintenance.store');
        });

        // GESTIÓN DE USUARIOS
        Route::resource('users', UserController::class)->names('admin.users');

        // BASE DE CONOCIMIENTO (MANUALES) 📚 ✅
        Route::prefix('knowledge')->group(function () {
            Route::get('/', [KnowledgeBaseController::class, 'index'])->name('admin.knowledge.index');
            Route::get('/create', [KnowledgeBaseController::class, 'create'])->name('admin.knowledge.create');
            Route::post('/', [KnowledgeBaseController::class, 'store'])->name('admin.knowledge.store');
            Route::get('/{id}/edit', [KnowledgeBaseController::class, 'edit'])->name('admin.knowledge.edit');
            Route::put('/{id}', [KnowledgeBaseController::class, 'update'])->name('admin.knowledge.update');
            Route::delete('/{id}', [KnowledgeBaseController::class, 'destroy'])->name('admin.knowledge.destroy');
            // 📊 REPORTES EJECUTIVOS
            Route::prefix('reports')->group(function () {
                Route::get('/', [ReportController::class, 'index'])->name('admin.reports.index');
                Route::get('/export/csv', [ReportController::class, 'exportCsv'])->name('admin.reports.csv');
                Route::get('/export/inventory-pdf', [ReportController::class, 'exportInventoryPdf'])->name('admin.reports.inventory.pdf');
            });
        });
        
        // BÚSQUEDA GLOBAL NEURAL 🧠
        Route::get('/global-search', [\App\Http\Controllers\Admin\GlobalSearchController::class, 'search'])->name('admin.global.search');

    });

    // --- 👔 PANEL DEL JEFE (BOSS) ---
    Route::prefix('boss')->group(function () {
        Route::get('/dashboard', [BossDashboardController::class, 'index'])->name('boss.dashboard');
    });

    // --- 🌍 RUTAS GLOBALES (COMO LAS PIDE TU NAVEGACIÓN) ---
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/inventory', [EquipmentController::class, 'index'])->name('inventory.index');
    
    // BASE DE CONOCIMIENTO PARA USUARIOS 📚
    Route::get('/knowledge-base', [\App\Http\Controllers\User\KnowledgeController::class, 'index'])->name('knowledge.index');
    Route::get('/knowledge/{id}', [\App\Http\Controllers\User\KnowledgeController::class, 'show'])->name('knowledge.show');

    // TICKETS PARA USUARIOS NORMALES 🎟️✨
    Route::prefix('my-tickets')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\TicketController::class, 'index'])->name('user.tickets.index');
        Route::get('/create', [\App\Http\Controllers\User\TicketController::class, 'create'])->name('user.tickets.create');
        Route::post('/', [\App\Http\Controllers\User\TicketController::class, 'store'])->name('user.tickets.store');
        Route::get('/{ticket}', [\App\Http\Controllers\User\TicketController::class, 'show'])->name('user.tickets.show');
        Route::post('/{ticket}/reply', [\App\Http\Controllers\User\TicketController::class, 'reply'])->name('user.tickets.reply');
    });

    // MOTOR DE INTELIGENCIA GRAVITYBOT 🧠🤖
    Route::get('/gravity-brain/search', [App\Http\Controllers\User\GravityBrainController::class, 'search'])->name('gravity.brain.search');
    Route::post('/gravity-bot/chat', [App\Http\Controllers\User\GravityBotController::class, 'chat'])->name('gravity.bot.chat');

    // PERFIL DE USUARIO 👤✨
    Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');

});

// --- 3. UTILIDADES DE EMERGENCIA ---
Route::get('/force-logout', function () {
    Auth::logout();
    return redirect('/login');
});

Route::get('/debug-role', function () {
    $user = auth()->user();
    return $user ? ['email' => $user->email, 'rol' => $user->role_id] : "No logueado";
})->middleware('auth');

// --- 4. RUTAS DE AUTENTICACIÓN EXTRA ---
require __DIR__ . '/auth.php';
