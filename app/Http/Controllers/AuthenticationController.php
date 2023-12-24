<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{
    //
    public function login(Request $request)
    {
        $user = User::where('email', $request['email'])->first();



        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);
        };


        $newToken = Str::random(15);

        return response()->json([
            "message" => "Berhasil Login!",
            "token" => $user->createToken($newToken, expiresAt:now()->addMonth())->plainTextToken
        ],200);



    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => 'Logout Berhasiil!'
        ],200);
    }
    public function me(Request $request)
    {
        return response()->json(Auth::user());
    }
}
