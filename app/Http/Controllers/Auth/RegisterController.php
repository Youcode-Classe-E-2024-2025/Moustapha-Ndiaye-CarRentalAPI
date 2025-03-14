<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    /**
     * @OA\Get(
     *     path="/register",
     *     summary="Show the registration form",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="Registration form displayed")
     * )
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }


    /**
     * @OA\Post(
     *     path="/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *             @OA\Property(property="password_confirmation", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(response=201, description="User registered successfully"),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
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
