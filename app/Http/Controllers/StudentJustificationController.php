<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Justification;


class StudentJustificationController extends Controller
{
    public function index()
    {
        $attendances = Attendance::query()
            ->where('user_id', Auth::id())
            ->whereIn('status', ['late', 'absent', 'excused'])
            ->with(['classSession.subject.group', 'justification'])
            ->latest()
            ->get();
        return view('student.student-justifications', compact('attendances'));
    }

    public function store(Request $request, Attendance $attendance)
{
    abort_unless((int) $attendance->user_id === (int) $request->user()->id, 403);
    abort_unless(in_array($attendance->status, ['absent', 'late'], true), 403);
    abort_unless($attendance->justification === null, 403);
    $data = $request->validate([
        'reason' => ['required', 'string', 'max:500'],
        'document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
    ]);
    $documentPath = null;
    if ($request->hasFile('document')) {
        $documentPath = $request->file('document')->store('justifications', 'public');
    }
    Justification::create([
        'attendance_id' => $attendance->id,
        'reason' => $data['reason'],
        'document_path' => $documentPath,
        'status' => 'pending',
    ]);
    return redirect()
        ->route('student.justifications')
        ->with('success', 'Justificante enviado. Pendiente de revisión.');
}
}
