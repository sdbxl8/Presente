<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Group;
use App\Models\User;
use App\Models\Subject;

class GroupController extends Controller
{
    public function index(){
        $groups = Auth::user()->groups;
        $students = User::where('role', 'student')
        ->whereNull('group_id')
        ->get();

        return view('teacher.teacher-group', compact('groups', 'students'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => ['required', 'string', 'max:25'],
    ]);

    $teacher = Auth::user();

    if (blank($teacher->subject_name)) {
        return back()->withErrors([
            'subject_name' => 'Tu cuenta todavía no tiene una asignatura asignada.',
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

    public function addStudents(Request $request, Group $group){

        abort_unless((int) $group->teacher_id === (int) Auth::id(),403);
        $data = $request->validate([
        'student_ids' => ['required', 'array'],
        'student_ids.*' => ['exists:users,id'],
    ]);

    User::whereIn('id', $data['student_ids'])
        ->where('role', 'student')
        ->update([
            'group_id' => $group->id,
        ]);

    return redirect()->route('teacher.groups');
    }

}
