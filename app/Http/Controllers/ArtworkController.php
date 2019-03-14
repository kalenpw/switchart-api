<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function store(Request $request)
    {
        $requestToken = $request->token;
        $token = JWTAuth::getToken();

        if ($token == $requestToken) {
            $apy = JWTAuth::getPayload($token)->toArray();
            $userId = $apy['sub'];
        } else {
            return "Not validated";
        }
        request()->validate([
            'name' => 'required',
            'artwork' => 'required',
            'token' => 'required'
        ]);
        $name = $request->name;
        $path = $request->file('artwork')->store('artworks');
        $game = \App\Game::where('name', $name)->first();
        $gameId = $game->id;

        return \App\Artwork::create([
            'userId' => $userId,
            'gameId' => $gameId,
            'votes' => 0,
            'fileName' => $path
        ]);
    }
}
