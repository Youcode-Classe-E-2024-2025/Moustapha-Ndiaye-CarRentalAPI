<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
      /**
     * @OA\Post(
     *     path="/login",
     *     summary="Authenticate user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User authenticated"),
     *     @OA\Response(response=302, description="Redirect to dashboard or user profile"),
     *     @OA\Response(response=401, description="Invalid credentials")
     * )
     */
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
