<?php

namespace App\EveOnline;

use Config;

use Evelabs\OAuth2\Client\Provider\EveOnline;

class EveOAuthFactory
{
    public static function create()
    {
        return new EveOnline([
            'clientId'     => Config::get('eveonline.id'),
            'clientSecret' => Config::get('eveonline.secret'),
            'redirectUri'  => url(Config::get('eveonline.callback'))
        ]);
    }
}
