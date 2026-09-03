<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GroupController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::view('/login', 'register-login.login')->name('login');
// Route::view('/register', 'register-login.register')->name('register');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/home', function () {
    return view('layouts.app');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/teacher/groups', [GroupController::class, 'index'])
        ->name('teacher.groups');

    Route::post('/teacher/groups', [GroupController::class, 'store'])
        ->name('teacher.groups.store');

});
