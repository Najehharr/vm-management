<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (!Auth::attempt($credentials)) {
            return response()->json(
                ['success' => false, 'message' => 'Invalid credentials']
                , 401);
        }


        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;


        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }
}
