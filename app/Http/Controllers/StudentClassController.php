<?php

namespace App\Http\Controllers;

use App\Models\ClassSession;
use Illuminate\Support\Facades\Auth;

class StudentClassController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        $classes = ClassSession::query()
            ->whereHas(
                'subject.group.students',
                function ($query) use ($student) {
                    $query->whereKey($student->id);
                }
            )
            ->with('subject.group.teacher')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('student.student-class', compact('classes'));
    }
}
