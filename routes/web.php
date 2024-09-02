<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facade\Facade;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\KtgMateriController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\PdKursusController;
use App\Http\Controlllers\Auth\RegisterController;

Auth::routes();

Route::middleware(['auth:admin'])->group(function () {
    // Route::get('/', function() {return view('home');
    // })->name('home');
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('categories', KtgMateriController::class);
    Route::resource('materies', MateriController::class);
    Route::resource('histories', HistoryController::class);
    Route::resource('courses', KursusController::class);
    Route::resource('students', MuridController::class);
    Route::resource('regists', PdKursusController::class);
    Route::post('regists/{id}/confirm-payment', [PdKursusController::class, 'confirmPayment'])->name('regist.payment');
    Route::get('/example', function () {
        return view('materies.example');
    });
    Route::get('/homez', function () {
        return view('homez');
    });
});