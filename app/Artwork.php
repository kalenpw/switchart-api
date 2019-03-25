<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    //
    protected $guarded = [];

    public function getNetVotes()
    {
        $votes = \App\Vote::where('artworkId', $this->id)->get();
        $totalVoteCount = 0;
        foreach ($votes as $vote) {
            $totalVoteCount = $totalVoteCount + $vote->vote;
        }
        return $totalVoteCount;
    }
}
