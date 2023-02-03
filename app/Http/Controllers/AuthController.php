<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\BaseController;

use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm() {

        return view('login');
    }

    public function showRegisterForm() {

        return view('register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('Access Token')->accessToken;

        return response()->json(['user' => $user, 'token' => $token], 200);
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('Access Token')->accessToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

}
