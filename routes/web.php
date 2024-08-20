<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controlllers\RegisterController;

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/admin/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});