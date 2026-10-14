<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSession;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function show(ClassSession $classSession)
{
    $classSession->loadMissing('subject');

    $student = Auth::user();

    abort_unless($student->role === 'student', 403); //verifica que eres alumno
    abort_unless($classSession->status === 'open', 403); //verifica que la clase este abierta
    abort_unless(
        (int) $student->group_id === (int) $classSession->subject->group_id,
        403
    );    //verifica que el alumno pertenezca al grupo de la clase

    return response('Enlace de asistencia válido');
}

public function store(Request $request, ClassSession $classSession)
{
    $classSession->loadMissing('subject');

    $student = $request->user();

    abort_unless($student->role === 'student', 403);
    abort_unless($classSession->status === 'open', 403);
    abort_unless(
        (int) $student->group_id === (int) $classSession->subject->group_id,
        403
    );

    $registeredAt = now();
    $startAt = \Illuminate\Support\Carbon::parse(
        $classSession->date . ' ' . $classSession->start_time
    );

    $status = $registeredAt->greaterThan($startAt->copy()->addMinutes(10))
        ? 'late'
        : 'present';

    $attendance = $classSession->attendances()->firstOrCreate(
        ['user_id' => $student->id],
        [
            'status' => $status,
            'registered_at' => $registeredAt,
        ]
    );

    if (! $attendance->wasRecentlyCreated) {
        return back()->with('error', 'Ya has registrado tu asistencia.');
    }

    return back()->with('success', 'Asistencia registrada correctamente.');
}
}
