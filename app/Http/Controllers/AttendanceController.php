<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSession;

class AttendanceController extends Controller
{
    public function show(Request $request, ClassSession $classSession)
    {
        $this->validateAttendanceControl($request, $classSession);

        return response('Enlace de asistencia válido');
    }

    public function store(Request $request, ClassSession $classSession)
    {
        $this->validateAttendanceControl($request, $classSession);

        $student = $request->user();
        $registeredAt = now();

        // Utilizamos updated_at como hora real de inicio del control.
        $controlStartedAt = $classSession->updated_at;

        // Los primeros diez minutos corresponden a asistencia puntual.
        $status = $registeredAt->greaterThan(
            $controlStartedAt->copy()->addMinutes(10)
        )
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

    /**
     * Comprueba que el control de asistencia sigue siendo válido.
     */
    private function validateAttendanceControl(
        Request $request,
        ClassSession $classSession
    ): void {
        $classSession->loadMissing('subject.group');

        $student = $request->user();

        // Solo pueden registrar asistencia los alumnos.
        abort_unless(
            $student && $student->role === 'student',
            403
        );

        // La clase debe encontrarse abierta.
        abort_unless(
            $classSession->status === 'open',
            403
        );

        // Comprobar que el QR pertenece a la apertura actual.
        $providedStartedAt = $request->query('started_at');

        $currentStartedAt = (string) $classSession->updated_at?->timestamp;

        abort_unless(
            is_string($providedStartedAt)
            && $providedStartedAt !== ''
            && hash_equals($currentStartedAt, $providedStartedAt),
            403
        );

        // El alumno debe pertenecer al grupo de esta clase.
        abort_unless(
            $classSession->subject->group
                ->students()
                ->whereKey($student->id)
                ->exists(),
            403
        );
    }

    public function scan()
    {
        return view('student.student-scan');
    }
}
