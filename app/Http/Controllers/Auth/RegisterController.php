<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function registrationUser(Request $request): RedirectResponse {
        // valide datas for registration
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed']
        ]);


        // create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role'  => 'user',
            'password' => Hash::make($request-> password),
        ]);

        return to_route('login')->with('sucess', 'Registration sucess');
    }
}
