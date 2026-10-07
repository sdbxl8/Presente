<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Justification;
use Illuminate\Support\Facades\Auth;

class JustificationController extends Controller
{
    public function index()
    {
        $justifications = Justification::with([
            'attendance.student',
            'attendance.classSession.subject.group',
        ])
        ->whereHas('attendance.classSession.subject.group', function ($query) {
            $query->where('teacher_id', Auth::id());
        })
        ->latest()
        ->get();

        return view('teacher.attendance-teacher', compact('justifications'));
    }

    public function approve(Justification $justification){
    abort_unless(
        $justification->attendance->classSession->subject->group->teacher_id === Auth::id(),
        403
    );

    $justification->update([
        'status' => 'accepted',
    ]);

    $justification->attendance()->update([
        'status' => 'excused',
    ]);

    return back();
}

public function reject(Justification $justification){
    abort_unless(
        $justification->attendance->classSession->subject->group->teacher_id === Auth::id(),
        403
    );

    $justification->update([
        'status' => 'rejected',
    ]);

    return back();
}
}
