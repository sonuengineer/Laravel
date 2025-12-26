<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        if (!$token = auth()->attempt($request->only('email','password'))) {
            return response()->json(['error'=>'Invalid'],401);
        }

        return response()->json([
            'token'=>$token,
            'user'=>auth()->user()
        ]);
    }
}
