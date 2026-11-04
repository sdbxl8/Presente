<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Justification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    abort_unless($justification->status === 'pending', 403);

    $justification->update([
        'status' => 'approved',
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
    abort_unless($justification->status === 'pending', 403);

    $justification->update([
        'status' => 'rejected',
    ]);

    return back();
}

public function download(Justification $justification)
{
    $justification->loadMissing('attendance.classSession.subject.group');

    abort_unless(
        (int) $justification->attendance->classSession->subject->group->teacher_id === (int) Auth::id(),
        403
    );

    abort_if(
        ! $justification->document_path
        || ! Storage::disk('public')->exists($justification->document_path),
        404
    );

    return response()->download(
    Storage::disk('public')->path($justification->document_path),
    basename($justification->document_path)
);
}
}
