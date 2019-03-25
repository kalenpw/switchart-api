<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class VoteController extends Controller
{
    public function artworkVotes($artworkId)
    {
        $artwork = \App\Artwork::where('id', $artworkId)->first();
        return $artwork->getNetVotes();
    }

    public function upvote(Request $request)
    {
        $artworkId = $request->artworkId;
        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->toArray();
        $userId = $apy['sub'];

        $vote = \App\Vote::where('userId', $userId)->where('artworkId', $artworkId)->first();

        //user has already voted on this artwork
        if ($vote) {
            //vote is a stupid name ->vote is + if upvote - if downvote 0 if neither
            $voteAmount = $vote->vote;
            if ($voteAmount == 1) {
                //user already upvoted this so undo that
                $vote->vote = 0;
            } else {
                $vote->vote = 1;
            }
            $vote->save();
        //new vote
        } else {
            $vote = \App\Vote::create([
                'userId' => $userId,
                'artworkId' => $artworkId,
                'vote' => 1
            ]);
        }

        return $vote;
    }

    public function downvote(Request $request)
    {
        $artworkId = $request->artworkId;
        $requestToken =  $request->token;
        $token = JWTAuth::getToken();
        $userId = -1;

        if ($token == $requestToken) {
            $apy = JWTAuth::getPayload($token)->toArray();
            $userId = $apy['sub'];
        } else {
            return "Not validated";
        }

        $vote = \App\Vote::where('userId', $userId)->where('artworkId', $artworkId)->first();

        //user has already voted on this artwork
        if ($vote) {
            //vote is a stupid name ->vote is + if upvote - if downvote 0 if neither
            $voteAmount = $vote->vote;
            if ($voteAmount == -1) {
                //user already downvoted this so undo that
                $vote->vote = 0;
            } else {
                $vote->vote = -1;
            }
            $vote->save();
        //new vote
        } else {
            $vote = \App\Vote::create([
                'userId' => $userId,
                'artworkId' => $artworkId,
                'vote' => -1
            ]);
        }

        return $vote;
    }
}
