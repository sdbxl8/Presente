<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    /**
     * Validar el acceso al QR.
     */
    private function validateAttendanceLink(Request $request, ClassSession $classSession)
    {
        $classSession->loadMissing('subject.group');

        $student = $request->user();

        abort_unless($student && $student->role === 'student', 403);

        abort_unless($classSession->status === 'open', 403);

        // Comprobar que el QR pertenece a la apertura actual.
        $startedAt = $request->query('started_at');

        abort_unless(
            $startedAt !== null
            && ctype_digit((string) $startedAt)
            && (int) $startedAt === $classSession->updated_at->timestamp,
            403
        );

        // Comprobar que el alumno pertenece al grupo.
        abort_unless(
            $classSession->subject->group
                ->students()
                ->whereKey($student->id)
                ->exists(),
            403
        );

        return $student;
    }

    public function show(Request $request, ClassSession $classSession)
    {
        $this->validateAttendanceLink($request, $classSession);

        return response('Enlace de asistencia válido');
    }

    public function store(Request $request, ClassSession $classSession)
    {
        $student = $this->validateAttendanceLink($request, $classSession);

        $registeredAt = now();

        // Los diez minutos comienzan cuando el profesor abre el control.
        $startedAt = Carbon::createFromTimestamp(
            (int) $request->query('started_at')
        );

        $status = $registeredAt->greaterThan(
            $startedAt->copy()->addMinutes(10)
        ) ? 'late' : 'present';

        $attendance = $classSession->attendances()->firstOrCreate(
            ['user_id' => $student->id],
            [
                'status' => $status,
                'registered_at' => $registeredAt,
            ]
        );

        if (! $attendance->wasRecentlyCreated) {
            return back()->with(
                'error',
                'Ya has registrado tu asistencia.'
            );
        }

        return back()->with(
            'success',
            'Asistencia registrada correctamente.'
        );
    }

    public function scan()
    {
        return view('student.student-scan');
    }
}
