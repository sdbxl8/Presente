<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

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
}
