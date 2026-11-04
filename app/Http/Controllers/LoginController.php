<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create(){
        return view('register-login.login');
    }

    public function store(Request $request){
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route(
                Auth::user()->role === 'student' ? 'student.home' : 'home'
            );
        }

        return back()->withErrors([
            'email' => 'las  credenciales no son correctas',
        ])->onlyInput('email');
    }
}
