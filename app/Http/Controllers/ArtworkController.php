<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function destroy(Request $request)
    {
        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->toArray();
        $userId = $apy['sub'];
        // return $request->id;
        $artwork = \App\Artwork::where('id', $request->id)->first();
        if ($userId = $artwork->userId) {
            $artwork->delete();
            return \Response::json(['message' => "Succesfully deleted."], 200);
        } else {
            return \Response::json(['message' => "You can only delete your own artworks."], 403);
        }
        return \Response::json(['message' => "Please login to delete an artwork."], 403);
    }

    public function getUsers($name)
    {
        $user = \App\User::where('name', $name)->first();
        $artworks = \App\Artwork::where('userId', $user->id)->get();
        return $artworks;
    }

    public function show($name)
    {
        $dbName = \App\Util\Util::getTitleFromFormattedTitle($name);
        $game = \App\Game::where('name', $dbName)->first();
        return \App\Artwork::where('gameId', $game->id)->get();
    }

    public function showId($id)
    {
        return \App\Artwork::where('id', $id)->first();
    }

    public function store(Request $request)
    {
        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->toArray();
        $userId = $apy['sub'];

        request()->validate([
            'name' => 'required',
            'artwork' => 'required|mimes:jpeg,jpg,png|max:11000',
            'token' => 'required'
        ]);
        $name = $request->name;
        $path = $request->file('artwork')->store('public/artworks');
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
