<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketApiController;

// Rutas Públicas (Si aplica el Login API)
// Route::post('/login', [AuthController::class, 'login']);

// Rutas Protegidas por Sanctum y CheckRole localmente configurado
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Devolver Usuario Autenticado en la API
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rutas protegidas exclusivas de técnicos/admins por la API
    Route::middleware('role:admin,supervisor,technician')->group(function () {
        
        // Tickets Endpoints
        Route::apiResource('tickets', TicketApiController::class);
        
        // Assets / Inventario Endpoints (ejemplo semántico)
        // Route::apiResource('assets', AssetApiController::class);
        
        // Usuarios Endpoints (ejemplo semántico)
        // Route::apiResource('users', UserApiController::class);
        
    });

    // Un usuario común que consume una App Móvil podría ver SUS tickets:
    Route::get('/my-tickets', function (Request $request) {
        return $request->user()->requestedTickets()->latest()->paginate(10);
    });
});
