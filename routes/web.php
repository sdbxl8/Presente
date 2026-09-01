<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('/login', 'register-login.login')->name('login');
Route::view('/register', 'register-login.register')->name('register');

