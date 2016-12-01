<?php
/**
 * Created by PhpStorm.
 * User: egor
 * Date: 01.12.2016
 * Time: 12:22
 */

namespace Vinlock\StreamAPI\Services;

use Vinlock\StreamAPI\StreamDriver;

class Goodgame extends Service
{
    function __construct($usernames) {
        if (!is_array($usernames) && is_string($usernames)) {
            $array = [$usernames];
        }

        $this->streams = StreamDriver::getStream($usernames, 'goodgame');
    }

    public static function game($game) {
        $game = \app\extensions\Helper::seoTranslit($game);

        $streams = StreamDriver::byGame($game, 'goodgame');
        return new Service($streams);
    }

}