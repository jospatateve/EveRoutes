<?php

namespace App\EveOnline;

use Cache;
use Config;

class EvePublicCREST
{
    private $oauth;
    private $crest;

    function __construct()
    {
        $this->oauth = EveOAuthFactory::create();
        $this->crest = Config::get('eveonline.public-crest');
    }

    private function getRequest($url)
    {
        $crestrequest = $this->oauth->getRequest('GET', $url);
        return $this->oauth->getResponse($crestrequest);
    }

    public function getSystems()
    {
        $url = $this->crest . 'solarsystems/';
        return $this->getRequest($url);
    }

    public function getSystem($systemid)
    {
        $url = $this->crest . "solarsystems/$systemid/";
        return Cache::remember("eve_system_$systemid", 60*24, function() use ($url) {
            return new EveSystem($this->getRequest($url));
        });
    }
}
