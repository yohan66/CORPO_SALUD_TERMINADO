<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\DesincorporacionController;
use App\Http\Controllers\LogAuditoriaController;
use App\Http\Controllers\ActaVerificacionController;
use App\Http\Controllers\VerificacionActaController;

Route::get('/', function () {
    return response()->json([
        'app' => 'Sistema de Control Patrimonial - CORPO SALUD TÁCHIRA',
        'version' => '1.0.0',
        'status' => 'operativo',
    ]);
});

Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/auth/me', [AuthController::class, 'me'])->middleware('auth');

Route::middleware(['auth', 'rol:admin_patrimonio,auditor'])->group(function () {
    Route::apiResource('bienes', BienController::class);
    Route::get('bienes/{bien}/qr', [BienController::class, 'qr'])->name('bienes.qr');
    Route::get('bienes/{bien}/etiqueta-pdf', [BienController::class, 'etiquetaPdf'])->name('bienes.etiqueta-pdf');
    Route::apiResource('desincorporaciones', DesincorporacionController::class);
    Route::apiResource('actas', ActaVerificacionController::class);
});

Route::middleware(['auth', 'rol:auditor'])->group(function () {
    Route::get('/logs', [LogAuditoriaController::class, 'index']);
    Route::get('/logs/{log}', [LogAuditoriaController::class, 'show']);
});

Route::middleware(['auth', 'rol:admin_patrimonio,directivo,auditor', '2fa'])->group(function () {
    Route::get('/actas/{acta}/pdf', [ActaVerificacionController::class, 'pdf'])->name('actas.pdf');
});

Route::get('/actas/verificar/{hash}', [VerificacionActaController::class, 'show'])->name('actas.verificar');
