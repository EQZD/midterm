<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', fn() => redirect('/login'));
Route::get('/register', [AuthController::class, 'showRegister']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'handleLogin']);
Route::get('/main', [AuthController::class, 'showMain']);
