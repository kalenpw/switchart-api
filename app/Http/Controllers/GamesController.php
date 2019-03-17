<?php

namespace App\Http\Controllers;

use \App\Util\Util;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index()
    {
        return \App\Game::all();
    }

    public function show($name)
    {
        $dbName = \App\Util\Util::getTitleFromFormattedTitle($name);
        return \App\Game::where('name', $dbName)->first();
    }

    public function store()
    {
        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->toArray();
        $userId = $apy['sub'];
        if (Util::isAdmin($userId)) {
            $attributes = request()->validate([
                'name' => 'required',
                'description' => 'required'
            ]);
            return \App\Game::create($attributes);
        }

        return \Response::json(['message' => "Not an admin"], 403);
    }
}
