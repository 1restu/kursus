<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facade\Facade;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\KtgMateriController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controlllers\Auth\RegisterController;

Auth::routes();

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/', function
     () {
        return view('home');
    })->name('home');

    Route::resource('categories', KtgMateriController::class);
    Route::resource('materies', MateriController::class);
    Route::get('/example', function () {
        return view('materies.example');
    });
});