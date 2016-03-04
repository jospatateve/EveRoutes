<?php

namespace App\EveOnline;

use Config;

class EvePublicCREST
{
    private $oauth;

    function __construct()
    {
        $this->oauth = EveOAuthFactory::create();
    }

    private function getRequest($url)
    {
        $crestrequest = $this->oauth->getRequest(
            'GET', $url
        );
        return $this->oauth->getResponse($crestrequest);
    }

    public function getSystems()
    {
        $url = Config::get('eveonline.public-crest').'solarsystems/';
        return $this->getRequest($url);
    }
}
