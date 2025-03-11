<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse{
        // retrive datas form
        $credentials = $request-> validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // check crudentials
        if (Auth::attempt($credentials)){
            if(Auth::user()->role === 'admin'){
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }else{
                return redirect()->intended('userProfil');
            }
        }

        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',

        ])->onlyInput('email');
    }
}
