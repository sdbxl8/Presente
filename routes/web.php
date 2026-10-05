<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\AttendanceController;

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
Route::get('/teacher/classes', [ClassController::class, 'index'])->name('teacher.classes');

Route::post('/teacher/classes', [ClassController::class, 'store'])->name('teacher.classes.store');
Route::delete('/teacher/classes/{classSession}', [ClassController::class, 'destroy'])->name('teacher.classes.destroy');

//redirecciones: clase abierta
Route::patch('/teacher/classes/{classSession}/open',[ClassController::class, 'open'])->name('teacher.classes.open');
Route::patch('/teacher/classes/{classSession}/close', [ClassController::class, 'close'])
    ->name('teacher.classes.close');

//redirecciones: asistencia
Route::middleware('auth')->group(function () {
    Route::get('/attendance/{classSession}', [AttendanceController::class, 'show'])
        ->middleware('signed')
        ->name('attendance.show');

    Route::post('/attendance/{classSession}', [AttendanceController::class, 'store'])
        ->middleware('signed')
        ->name('attendance.store');
});

//api calendario
Route::get('/api/classes', function () {
    $classes = \App\Models\ClassSession::with('subject.group')->get();

    return $classes->map(function ($class) {
        return [
            'id' => $class->id,
            'title' => $class->subject->name,
            'start' => $class->date . 'T' . $class->start_time,
            'end' => $class->date . 'T' . $class->end_time,
            'extendedProps' => [
                'group' => $class->subject->group->name,
                'status' => $class->status,
            ],
        ];
    });
});

//redirecciones: justificantes
Route::get('/teacher/justifications', function () {
    return view('teacher.attendance-teacher');
})->name('teacher.justifications');
});
