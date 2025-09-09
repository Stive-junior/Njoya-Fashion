<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Routes pour la gestion de l'authentification des utilisateurs dans l'application
| Afrix. Inclut la connexion, l'inscription, la vérification d'e-mail, la
| réinitialisation de mot de passe, et l'authentification OAuth via Google.
|
*/

Route::middleware(['guest', 'no.cache'])->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/email/verify', [AuthenticatedSessionController::class, 'verifyEmail'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.notice');
    
    
});


Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');