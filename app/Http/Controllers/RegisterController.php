<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class RegisterController extends Controller
{
    public function create(){
        return view('register-login.register');
    }

    public function store(Request $request){

        $data = $request->validate([
            'name' => ['required','string','max:25'],
            'surname' => ['required','string','max:40'],
            'email' => ['required','string','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8'],
            'role' => ['required','in:teacher,student'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect()->route('login')->with('success','usuario registrado correctamente');
    }

}
