<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSession;
use Illuminate\Support\Facades\Auth;

class StudentClassController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $classes = ClassSession::query()
            ->whereHas('subject', function ($query) use ($student) {
                $query->where('group_id', $student->group_id);
            })
            ->with('subject.group.teacher')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
        return view('student.student-class', compact('classes'));
    }
}
