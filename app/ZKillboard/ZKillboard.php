<?php

namespace App\ZKillboard;

use Config;

use League\OAuth2\Client\Provider\GenericProvider;

class ZKillboard
{
    private $zkill;
    private $api;

    function __construct()
    {
        $this->zkill = new GenericProvider([
            'urlAuthorize' => '',
            'urlAccessToken' => '',
            'urlResourceOwnerDetails' => ''
        ]);
        $this->api = Config::get('zkillboard.api');
    }

    private function getRequest($url)
    {
        $request = $this->zkill->getRequest('GET', $url);
        return $this->zkill->getResponse($request);
    }

    public function getSystemStats($systemid)
    {
        $url = $this->api . "stats/solarSystemID/$systemid/";
        return $this->getRequest($url);
    }

    public function getSystemLatestKill($systemid)
    {
        $url = $this->api . "kills/solarSystemID/$systemid/orderDirection/desc/limit/1/";
        return $this->getRequest($url)[0];
    }
}
