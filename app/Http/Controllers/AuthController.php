<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\BaseController;

use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('Access Token')->accessToken;

        return response()->json(['user' => $user, 'token' => $token, 'message' => 'login successfully'], 200);
    }

    public function register(Request $request)
    {

        $inputs = $request->only(['name', 'email', 'password']);

        $validate_data = [
            'name'      => 'required|string',
            'email'     => 'required|email',
            'password'  => 'required|min:8'
        ];

        $validator = Validator::make($inputs, $validate_data);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Format Error',
                'erros'   => $validator->errors()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('Access Token')->accessToken;

        return response()->json(['user' => $user, 'token' => $token, 'message' => 'register successfully'], 201);
    }

    public function logout(Request $request) {
        Auth::user()->token()->revoke();
        return response()->json(['message' => 'logout successfully'], 200);
    }

}
