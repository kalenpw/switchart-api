<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function register(Request $request)
    {
        $user = User::create([
            'email'    => $request->email,
            'name' => $request->name,
            'password' => hash('sha256', ($request->password))
        ]);

        $token = auth()->login($user);
        return $token;

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $email = request('email');
        // $password = request('password');
        $password = hash('sha256', request('password'));
        $user = User::where('email', $email)
            ->where('password', $password)
            ->first();
        if ($user) {
            $token = auth()->login($user);
            return $this->respondWithToken($token);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
