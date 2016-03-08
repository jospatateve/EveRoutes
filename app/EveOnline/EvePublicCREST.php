<?php

namespace App\EveOnline;

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
        $crestrequest = $this->oauth->getRequest(
            'GET', $url
        );
        return $this->oauth->getResponse($crestrequest);
    }

    public function getSystems()
    {
        return $this->getRequest($this->crest . 'solarsystems/');
    }

    public function getSystem($systemid)
    {
        return new EveSystem(
            $this->getRequest($this->crest . "solarsystems/$systemid/")
        );
    }
}
