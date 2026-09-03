<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;

class GroupController extends Controller
{
    public function index(){
        $groups = Auth::user()->groups;
        return view('teacher.teacher-group',compact('groups'));
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

}
