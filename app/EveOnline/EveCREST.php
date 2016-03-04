<?php

namespace App\EveOnline;

use Illuminate\Http\Request;

use Config;

class EveCREST
{
    private $oauth;

    function __construct(EveOAuthProviderInterface $oauth)
    {
        $this->oauth = $oauth;
    }

    private function getOrUpdateToken(Request $request)
    {
        $token = $this->oauth->getToken($request);

        if ($token->hasExpired()) {
            $token = $this->oauth->getOAuth()->getAccessToken('refresh_token', [
                'refresh_token' => $token->getRefreshToken()
            ]);
            $this->oauth->setToken($request, $token);
        }

        return $token;
    }

    private function getRequest(Request $request, $url)
    {
        $token = $this->getOrUpdateToken($request);

        $crestrequest = $this->oauth->getOAuth()->getAuthenticatedRequest(
            'GET', $url, $token
        );
        return $this->oauth->getOAuth()->getResponse($crestrequest);
    }

    private function postRequest(Request $request, $url, $json)
    {
        $token = $this->getOrUpdateToken($request);

        $crestrequest = $this->oauth->getOAuth()->getAuthenticatedRequest(
            'POST', $url, $token, [ 'content' => $json ]
        );
        return $this->oauth->getOAuth()->getResponse($crestrequest);
    }

    public function getLocation(Request $request, $userid)
    {
        $url = Config::get('eveonline.crest')."characters/$userid/location/";
        return $this->getRequest($request, $url);
    }

    public function getLocationInfo(Request $request, $userid)
    {
        $location = $this->getLocation($request, $userid);
        if (!isset($location['solarSystem'])) {
            return false;
        }

        return $this->getRequest($request, $location['solarSystem']['href']);
    }

    public function setWaypoint(Request $request, $userid, $waypoint, $reset=false)
    {
        $waypoint_json[] = [
            'solarSystem' => [
                'href' => Config::get('eveonline.crest')."solarsystems/$waypoint/",
                'id' => $waypoint
            ],
            'first' => false,
            'clearOtherwaypoints' => $reset
        ];

        $url = Config::get('eveonline.crest')."characters/$userid/navigation/waypoints/";

        return $this->postRequest($request, $url, json_encode($waypoint_json));
    }

    public function setWaypoints(Request $request, $userid, $waypoints = [])
    {
        $reset = true;
        foreach ($waypoints as $waypoint) {
            $this->setWaypoint($request, $userid, $waypoint, $reset);
            $reset = false;
        }
    }

    public function getUserInfo(Request $request, $userid)
    {
        $url = Config::get('eveonline.crest')."characters/$userid/";
        return $this->getRequest($request, $url);
    }

    private function getRequestPublic($url)
    {
        $crestrequest = $this->oauth->getOAuth()->getRequest(
            'GET', $url
        );
        return $this->oauth->getOAuth()->getResponse($crestrequest);
    }

    public function getSystems()
    {
        $url = Config::get('eveonline.public-crest').'solarsystems/';
        return $this->getRequestPublic($url);
    }
}
