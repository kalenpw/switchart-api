<?php

namespace App\Util;

class Util
{
    /**
     * Removes any non alphanumeric characters and replaces white space with underscores
     * @param string $title - the title to be formatted
     * @return string - a title with only alphanumeric characters an no spaces
     */
    public static function formatGameName(string $title):string
    {
        $alphaNumeric = preg_replace("/[^A-Za-z0-9 ]/", '', $title);
        $spacesRemoved = preg_replace('/\s+/', '_', $alphaNumeric);
        return $spacesRemoved;
    }

    public static function getTitleFromFormattedTitle(string $title):string
    {
        $games = \App\Game::all();
        foreach ($games as $game) {
            if (self::formatGameName($game->title) == $title) {
                return $game->title;
            }
        }
        return "";
    }
}
