<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Subject;
use App\Models\ClassSession;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


class ClassController extends Controller
{
    public function index(){
        $user = User::findOrFail(Auth::id());
        $groups = $user->groups()->with('subjects')->get();
        $classes = ClassSession::whereHas('subject.group', function ($query) {$query->where('teacher_id', Auth::id());})->with('subject.group')->get();
        return view('teacher.teacher-class', compact('groups', 'classes'));
    }

    public function store(Request $request){

            $data =$request->validate([
               'group_id' => ['required','exists:groups,id'],
               'subject_id' => ['required','exists:subjects,id'],
               'date' => ['required','date'],
               'start_time' => ['required'],
               'end_time' => ['required']
            ]);

            ClassSession::create([
                'subject_id' => $data['subject_id'],
                'date' => $data['date'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'status' => 'scheduled'
            ]);

            return redirect()->route('teacher.classes');
    }

    // public function open(ClassSession $classSession){

    //     $classSession->load('subject.group');

    //     abort_unless(
    //         $classSession->subject->group->teacher_id === Auth::id(),403
    //     );
    //     $expiresAt = Carbon::parse(
    //         $classSession->date . ' ' . $classSession->end_time
    //     );

    //       abort_unless($expiresAt->isFuture(), 409);

    //     $attendanceUrl = URL::temporarySignedRoute(
    //         'attendance.show',
    //     $expiresAt,
    //         [
    //             'classSession' => $classSession->id,
    //             'nonce' => Str::random(32),
    //         ]
    //     );

    //     $classSession->update([
    //         'status' => 'open',
    //     ]);

    //     return redirect()
    //         ->route('teacher.classes')
    //         ->with('open_class_id', $classSession->id)
    //         ->with('attendance_url', $attendanceUrl);

    // }

    public function open(ClassSession $classSession)
{
    $classSession->load('subject.group');

    abort_unless(
        $classSession->subject->group->teacher_id === Auth::id(),
        403
    );

    $expiresAt = Carbon::parse(
        $classSession->date . ' ' . $classSession->end_time
    );

    $attendanceUrl = URL::temporarySignedRoute(
        'attendance.show',
        $expiresAt,
        [
            'classSession' => $classSession->id,
            'nonce' => Str::random(32),
        ]
    );

    $classSession->update([
        'status' => 'open',
    ]);

    return redirect()
        ->route('teacher.classes')
        ->with('open_class_id', $classSession->id)
        ->with('attendance_url', $attendanceUrl);
}

    public function close(ClassSession $classSession)
{
    $classSession->load('subject.group');

    abort_unless(
        $classSession->subject->group->teacher_id === Auth::id(),
        403
    );

    $classSession->update([
        'status' => 'closed',
    ]);

    return redirect()->route('teacher.classes');
}

    public function destroy(ClassSession $classSession)
{
    $classSession->delete();

    return redirect()->route('teacher.classes');
}

}
