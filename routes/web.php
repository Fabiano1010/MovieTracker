<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImdbController;
use Illuminate\Support\Facades\Route;



Route::inertia('/', 'Home')->name('home');


Route::middleware('auth')->group(function () {

    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');



    Route::prefix('movies')->group(function () {
        Route::get('/search', [ImdbController::class, 'search'])->name('movies.search');
        Route::get('/title', [ImdbController::class, 'getTitle'])->name('movies.title');;
        Route::get('/popular', [ImdbController::class, 'getPopular'])->name('movies.popular');;
    });

});

Route::middleware('guest')->group(function () {

    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::post('/register',[AuthController::class,'register']);

    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login',[AuthController::class,'Login']);

});




