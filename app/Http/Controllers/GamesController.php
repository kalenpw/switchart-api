<?php

namespace App\Http\Controllers;

use \App\Util\Util;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index()
    {
        return \App\Game::orderBy('name')->get();
    }

    public function byId($id)
    {
        return \App\Game::where('id', $id)->first();
    }

    public function update(Request $request)
    {
        $token = JWTAuth::getToken();
        $id = $request->id;
        $name = $request->name;
        $description = $request->description;

        $apy = JWTAuth::getPayload($token)->toArray();
        $userId = $apy['sub'];
        if (Util::isAdmin($userId)) {
            $game = \App\Game::where('id', $id)->first();
            $game->name = $name;
            $game->description = $description;
            return \Response::json($game->save());
        }
        return \Response::json(['message' => "Not an admin"], 403);
    }

    public function show($name)
    {
        $dbName = \App\Util\Util::getTitleFromFormattedTitle($name);
        return \App\Game::where('name', $dbName)->first();
    }

    public function store(Request $request)
    {
        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->toArray();
        $userId = $apy['sub'];
        if (Util::isAdmin($userId)) {
            $attributes = request()->validate([
                'token' => 'required',
                'name' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png'
            ]);
            $name = $request->name;
            $description = $request->description;
            $path = $request->file('image')->store('public/games');
            return \App\Game::create([
                'name' => $name,
                'description' => $description,
                'image' => $path
            ]);
        }

        return \Response::json(['message' => "Not an admin"], 403);
    }
}
