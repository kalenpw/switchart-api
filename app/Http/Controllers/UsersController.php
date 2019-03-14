<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersController extends Controller
{
    //
    public function show()
    {
        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->toArray();
        $userId = $apy['sub'];
        if ($userId == 1) {
            //admin
        }
        return \App\User::where('id', $userId)->first();
    }
}
