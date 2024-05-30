<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        try {
            $data =  $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if(!Auth::attempt($request->only('email', 'password'))){
                return response()->json(['message' => 'wrong credentials'], 401);
            }

            $user = User::where('email', $data['email'])->first();
            $token = $user->createToken('user')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th], 500);
        }
    }

    public function logout(Request $request){
        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }
}
