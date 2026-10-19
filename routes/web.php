<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\JustificationController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentClassController;


Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
//redireccion segun el rol de usuario al iniciar sesion
    return Auth::user()->role === 'student'
        ? redirect()->route('student.home')
        : redirect()->route('home');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

//redirecciones: interfaz de inicio profesor
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/home', [TeacherDashboardController::class, 'dashboard'])
        ->name('home');

    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'dashboard'])
        ->name('teacher.dashboard');
});

//redirecciones: interfaz de inicio estudiante
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/home', [StudentDashboardController::class, 'dashboard'])
        ->name('student.home');
});

//redirecciones: grupos profesor
Route::middleware(['auth', 'role:teacher'])->group(function () {
Route::get('/teacher/groups', [GroupController::class, 'index'])->name('teacher.groups');

Route::post('/teacher/groups', [GroupController::class, 'store'])->name('teacher.groups.store');
Route::post('/teacher/groups/{group}/students',[GroupController::class, 'addStudents'])->name('teacher.groups.students');

//redirecciones: clases profesor
Route::get('/teacher/classes', [ClassController::class, 'index'])->name('teacher.classes');

Route::post('/teacher/classes', [ClassController::class, 'store'])->name('teacher.classes.store');
Route::delete('/teacher/classes/{classSession}', [ClassController::class, 'destroy'])->name('teacher.classes.destroy');

//redirecciones: clase abierta
Route::patch('/teacher/classes/{classSession}/open',[ClassController::class, 'open'])->name('teacher.classes.open');
Route::patch('/teacher/classes/{classSession}/close', [ClassController::class, 'close'])
    ->name('teacher.classes.close');
});


//redirecciones: asistencia
Route::middleware(['auth', 'role:student'])->group(function () {
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
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/justifications', [JustificationController::class, 'index'])
        ->name('teacher.justifications');

    Route::patch('/teacher/justifications/{justification}/approve', [JustificationController::class, 'approve'])
        ->name('teacher.justifications.approve');

    Route::patch('/teacher/justifications/{justification}/reject', [JustificationController::class, 'reject'])
        ->name('teacher.justifications.reject');
});

//redirecciones: perfil
Route::middleware('auth')->group(function () {
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.photo.update');
});

//redirecciones: escaner
    Route::middleware(['auth', 'role:student'])->group(function () {
        Route::get('/student/scan', [AttendanceController::class, 'scan'])
            ->name('student.scan');
    });

//redirecciones: clases estudiante
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/class', [ClassController::class, 'index'])
        ->name('student.class');
});
