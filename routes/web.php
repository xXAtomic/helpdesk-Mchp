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
            Route::get('/{id}/label', [EquipmentController::class, 'generateLabel'])->name('admin.inventory.label');
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

        // 👨‍⚖️ GESTIÓN DE COMPLIANCE
        Route::prefix('compliance')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ComplianceController::class, 'index'])->name('admin.compliance.index');
            Route::get('/create', [\App\Http\Controllers\Admin\ComplianceController::class, 'create'])->name('admin.compliance.create');
            Route::post('/', [\App\Http\Controllers\Admin\ComplianceController::class, 'store'])->name('admin.compliance.store');
            Route::get('/{id}', [\App\Http\Controllers\Admin\ComplianceController::class, 'show'])->name('admin.compliance.show');
            Route::get('/{id}/edit', [\App\Http\Controllers\Admin\ComplianceController::class, 'edit'])->name('admin.compliance.edit');
            Route::put('/{id}', [\App\Http\Controllers\Admin\ComplianceController::class, 'update'])->name('admin.compliance.update');
            Route::delete('/{id}', [\App\Http\Controllers\Admin\ComplianceController::class, 'destroy'])->name('admin.compliance.destroy');
            Route::delete('/signature/{id}', [\App\Http\Controllers\Admin\ComplianceController::class, 'destroySignature'])->name('admin.compliance.signature.destroy');
        });

        // GESTIÓN DE INSUMOS 📦
        Route::resource('supplies', \App\Http\Controllers\Admin\SupplyController::class)->names('admin.supplies');
        Route::post('/supplies/{supply}/dispatch', [\App\Http\Controllers\Admin\SupplyController::class, 'dispatch'])->name('admin.supplies.dispatch');
        Route::post('/supplies/{supply}/restock', [\App\Http\Controllers\Admin\SupplyController::class, 'restock'])->name('admin.supplies.restock');
        Route::post('/supplies/logs/{log}/return', [\App\Http\Controllers\Admin\SupplyController::class, 'return'])->name('admin.supplies.return');

    });

    // --- 👔 PANEL DEL JEFE (BOSS) ---
    Route::prefix('boss')->group(function () {
        Route::get('/dashboard', [BossDashboardController::class, 'index'])->name('boss.dashboard');
        Route::get('/reports', [BossDashboardController::class, 'reports'])->name('boss.reports');
    });

    // --- 🌍 RUTAS GLOBALES (COMO LAS PIDE TU NAVEGACIÓN) ---
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/inventory', [EquipmentController::class, 'index'])->name('inventory.index');
    
    // BASE DE CONOCIMIENTO PARA USUARIOS 📚
    Route::get('/knowledge-base', [\App\Http\Controllers\User\KnowledgeController::class, 'index'])->name('knowledge.index');
    Route::get('/knowledge-base/suggest', [\App\Http\Controllers\User\KnowledgeController::class, 'suggest'])->name('knowledge.suggest');
    Route::get('/knowledge/{id}', [\App\Http\Controllers\User\KnowledgeController::class, 'show'])->name('knowledge.show');

    // TICKETS PARA USUARIOS NORMALES 🎟️✨
    Route::prefix('my-tickets')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\TicketController::class, 'index'])->name('user.tickets.index');
        Route::get('/create', [\App\Http\Controllers\User\TicketController::class, 'create'])->name('user.tickets.create');
        Route::post('/', [\App\Http\Controllers\User\TicketController::class, 'store'])->name('user.tickets.store');
        Route::get('/{ticket}', [\App\Http\Controllers\User\TicketController::class, 'show'])->name('user.tickets.show');
        Route::post('/{ticket}/reply', [\App\Http\Controllers\User\TicketController::class, 'reply'])->name('user.tickets.reply');
        Route::post('/{ticket}/rate', [\App\Http\Controllers\User\TicketController::class, 'rate'])->name('user.tickets.rate');
    });

    // MOTOR DE INTELIGENCIA GRAVITYBOT 🧠🤖
    Route::get('/gravity-brain/search', [App\Http\Controllers\User\GravityBrainController::class, 'search'])->name('gravity.brain.search');
    Route::post('/gravity-brain/deflect', [App\Http\Controllers\User\GravityBrainController::class, 'deflect'])->name('gravity.brain.deflect');
    Route::post('/gravity-bot/chat', [App\Http\Controllers\User\GravityBotController::class, 'chat'])->name('gravity.bot.chat');

    // PERFIL DE USUARIO 👤✨
    Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');

    // ⚖️ COMPLIANCE PARA USUARIOS
    Route::prefix('compliance')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\ComplianceController::class, 'index'])->name('user.compliance.index');
        Route::get('/{id}', [\App\Http\Controllers\User\ComplianceController::class, 'show'])->name('user.compliance.show');
        Route::post('/{id}/sign', [\App\Http\Controllers\User\ComplianceController::class, 'sign'])->name('user.compliance.sign');
        Route::get('/{id}/download', [\App\Http\Controllers\User\ComplianceController::class, 'downloadPDF'])->name('user.compliance.download');
    });

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
