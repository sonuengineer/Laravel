<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class AuthController extends Controller
// {
//     public function login(Request $request) {
//         if (!$token = auth()->attempt($request->only('email','password'))) {
//             return response()->json(['error'=>'Invalid'],401);
//         }

//         return response()->json([
//             'token'=>$token,
//             'user'=>auth()->user()
//         ]);
//     }
// }




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

        // 🔥 IMPORTANT: use JWT guard explicitly
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'user' => Auth::guard('api')->user(),
        ]);
    }
}

