<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
     /**
     * @OA\Get(
     *     path="/user/profile",
     *     summary="Display user profile",
     *     tags={"User"},
     *     @OA\Response(response=200, description="User profile page displayed")
     * )
     */
    public function showProfile()
    {
        return view('user.userProfil'); 
    }
    /**
     * @OA\Get(
     *     path="/admin/dashboard",
     *     summary="Display admin dashboard",
     *     tags={"Admin"},
     *     @OA\Response(response=200, description="Admin dashboard page displayed")
     * )
     */
    public function showDashboard()
    {
        return view('admin.dashboard'); 
    }
}
