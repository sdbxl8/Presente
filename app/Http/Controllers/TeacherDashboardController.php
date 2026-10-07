<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\ClassSession;
use App\Models\Justification;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function dashboard()
{
    $teacherId = Auth::id();

    $groups = Group::where('teacher_id', $teacherId)->with('subjects')->get();

    $upcomingClasses = ClassSession::with('subject.group')
        ->whereHas('subject.group', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
        ->orderBy('date', 'asc')
        ->limit(5)
        ->get();

    $pendingJustifications = Justification::with([
        'attendance.student',
        'attendance.classSession.subject.group',
    ])
    ->whereHas('attendance.classSession.subject.group', function ($query) use ($teacherId) {
        $query->where('teacher_id', $teacherId);
    })
    ->where('status', 'pending')
    ->latest()
    ->get();

    return view('teacher.teacher-dashboard', compact('groups', 'upcomingClasses', 'pendingJustifications'));
}
}
