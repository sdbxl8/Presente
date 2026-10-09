<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function store(Request $request){
        $data = $request->validate([
            'name'=>['required','string', 'max:25']
        ]);

        Group::create([
            'name'=>$data['name'],
            'teacher_id'=>Auth::id()
        ]);

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

    public function storeSubject(Request $request, Group $group)
{
    abort_unless($group->teacher_id === Auth::id(), 403);

    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
    ]);

    Subject::create([
        'name' => $data['name'],
        'group_id' => $group->id,
    ]);

    return redirect()->route('teacher.groups');
}

    public function addSubjects(Request $request, Group $group){
    $data = $request->validate([
        'subject_ids' => ['required', 'array'],
        'subject_ids.*' => ['exists:subjects,id'],
    ]);

    Subject::whereIn('id', $data['subject_ids'])
        ->update([
            'group_id' => $group->id,
        ]);

    return redirect()->route('teacher.groups');
    }
}
