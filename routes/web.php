<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GroupController;
use App\Models\ClassSession;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/home', function () {
    return view('layouts.app');
})->name('home');

//redirecciones: grupos profesor
Route::middleware('auth')->group(function () {
Route::get('/teacher/groups', [GroupController::class, 'index'])->name('teacher.groups');

Route::post('/teacher/groups', [GroupController::class, 'store'])->name('teacher.groups.store');
Route::post('/teacher/groups/{group}/students',[GroupController::class, 'addStudents'])->name('teacher.groups.students');
Route::post('/teacher/groups/{group}/subjects',[GroupController::class, 'addSubjects'])->name('teacher.groups.subjects');

//redirecciones: clases profesor
Route::get('/teacher/classes', function () {
    $groups = Group::where('teacher_id', Auth::id())->with('subjects')->get();
    $classes = ClassSession::whereHas('subject.group', function ($query) {
        $query->where('teacher_id', Auth::id());
    })->with('subject.group')->orderBy('date')->orderBy('start_time')->get();

    return view('teacher.teacher-class', compact('groups', 'classes'));
})->name('teacher.classes');

Route::post('/teacher/classes', function () {
    return redirect()->route('teacher.classes');
})->name('teacher.classes.store');
});
