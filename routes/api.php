<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — v1
|--------------------------------------------------------------------------
|
| Format response: JSON
| Autentikasi: Laravel Sanctum (stateless token)
| Rate Limiting: 60 request/menit per IP (default Laravel)
|
*/

Route::prefix('v1')->group(function () {

    // ─── AUTH (Public) ─────────────────────────────────────────────────────
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login',    [AuthController::class, 'login'])->name('login');

        // Protected auth routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/me',     [AuthController::class, 'me'])->name('me');
        });
    });

    // ─── CONTACTS ──────────────────────────────────────────────────────────
    Route::prefix('contacts')->name('contacts.')->group(function () {

        /*
         * POST /api/v1/contacts
         * Kirim pesan — bisa guest maupun user yang sudah login.
         * Tidak pakai middleware auth agar guest bisa akses.
         * Di ContactController::store(), $request->user() akan null jika guest.
         */
        Route::post('/', [ContactController::class, 'store'])->name('store');

        // Admin only: perlu token Sanctum + role admin
        Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
            Route::get('/',                           [ContactController::class, 'index'])->name('index');
            Route::get('/{id}',                       [ContactController::class, 'show'])->name('show');
            Route::patch('/{contact}/status',         [ContactController::class, 'updateStatus'])->name('update-status');
            Route::delete('/{contact}',               [ContactController::class, 'destroy'])->name('destroy');
        });
    });

    // ─── PROFILE (Protected) ──────────────────────────────────────────────
    Route::prefix('profile')->name('profile.')->middleware('auth:sanctum')->group(function () {
        Route::get('/',          [ProfileController::class, 'show'])->name('show');
        Route::put('/',          [ProfileController::class, 'update'])->name('update');
        Route::put('/password',  [ProfileController::class, 'updatePassword'])->name('update-password');
    });
});
