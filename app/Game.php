<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $guarded = [];

    public function getArtworks()
    {
        return \App\Artwork::where('gameId', $this->id)->get();
    }
}
