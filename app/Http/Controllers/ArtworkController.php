<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function store(Request $request)
    {
        $request->file('artwork')->store('artworks');
        return "succ";
        return $request->file('artwork');
        request()->validate([
            'name' => 'required',
            'file' => 'required'
        ]);

        $path = $request->file('artwork')->store('artworks');
        return $path;
    }
}
