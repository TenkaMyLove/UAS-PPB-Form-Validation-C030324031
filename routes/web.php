<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.contacts.index')
            : redirect()->route('contacts.form');
    }
    return redirect()->route('login');
});

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Contact form (guest + user)
Route::get('/kontak', [ContactController::class, 'form'])->name('contacts.form');
Route::post('/kontak', [ContactController::class, 'store'])->name('contacts.store');

// Profile (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profil/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/pesan', [AdminController::class, 'index'])->name('contacts.index');
    Route::get('/pesan/{contact}', [AdminController::class, 'show'])->name('contacts.show');
    Route::patch('/pesan/{contact}/status', [AdminController::class, 'updateStatus'])->name('contacts.status');
    Route::delete('/pesan/{contact}', [AdminController::class, 'destroy'])->name('contacts.destroy');
});
