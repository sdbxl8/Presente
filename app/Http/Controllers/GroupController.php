<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    public function index()
{
    $groups = Group::query()
        ->where('teacher_id', Auth::id())
        ->with(['subjects', 'students'])
        ->get();

    $students = User::query()
        ->where('role', 'student')
        ->orderBy('surname')
        ->orderBy('name')
        ->get();

    return view(
        'teacher.teacher-group',
        compact('groups', 'students')
    );
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:25'],
        ]);

        $teacher = Auth::user();

        if (blank($teacher->subject_name)) {
            return back()->withErrors([
                'subject_name' =>
                    'Tu cuenta todavía no tiene una asignatura asignada.',
            ]);
        }

        DB::transaction(function () use ($teacher, $data) {
            $group = Group::create([
                'name' => $data['name'],
                'teacher_id' => $teacher->id,
            ]);

            $group->subjects()->create([
                'name' => $teacher->subject_name,
            ]);
        });

        return redirect()->route('teacher.groups');
    }

    public function addStudents(Request $request, Group $group)
    {
        // El profesor solo puede gestionar sus propios grupos.
        abort_unless(
            (int) $group->teacher_id === (int) Auth::id(),
            403
        );

        $data = $request->validate([
            'student_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'student_ids.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('users', 'id')->where(
                    fn ($query) => $query->where('role', 'student')
                ),
            ],
        ]);

        // Añade las inscripciones que faltan sin eliminar
        // las que el alumno tenga en otros grupos.
        $group->students()->syncWithoutDetaching(
            $data['student_ids']
        );

        return redirect()->route('teacher.groups');
    }
}
