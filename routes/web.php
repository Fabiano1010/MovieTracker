<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImdbController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserMovieController;


Route::get('/', [ImdbController::class, 'getPopular'])->name('home');


Route::middleware('auth')->group(function () {

    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::inertia('/search', 'Search')->name('search');

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

    Route::apiResource('user-movies', UserMovieController::class);

    Route::prefix('movies')->group(function () {
        Route::get('/search', [ImdbController::class, 'search'])->name('movies.search');
        Route::get('/title', [ImdbController::class, 'getTitle'])->name('movies.title');
        Route::get('/popular', [ImdbController::class, 'getPopular'])->name('movies.popular');


        Route::get('/user-movies', [UserMovieController::class, 'index'])
            ->name('movies.index');
        Route::post('/user-movies', [UserMovieController::class, 'store'])
            ->name('movies.store');

        Route::delete('/user-movies/{movieId}', [UserMovieController::class, 'deleteByMovieId'])
            ->name('movies.destroy');

        Route::get('/user-movies/{id}', [UserMovieController::class, 'getByMovieId'])
            ->name('movies.show');
        Route::put('/user-movies/{id}', [UserMovieController::class, 'update'])
            ->name('movies.update');

    });

});

Route::middleware('guest')->group(function () {

    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::post('/register',[AuthController::class,'register']);

    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login',[AuthController::class,'Login']);

});




