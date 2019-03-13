<?php

namespace App\Http\Controllers;

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
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        return \App\Game::create($attributes);
    }
}
