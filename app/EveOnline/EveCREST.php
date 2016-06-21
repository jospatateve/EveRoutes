<?php

namespace App\EveOnline;

use Illuminate\Http\Request;

use Config;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class EveCREST
{
    private $oauth;
    private $crest;

    function __construct(EveOAuthProviderInterface $oauth)
    {
        $this->oauth = $oauth;
        $this->crest = Config::get('eveonline.crest');
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

    private function postRequest(Request $request, $url, $body)
    {
        $token = $this->getOrUpdateToken($request);

        $options = [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode($body)
        ];

        $crestrequest = $this->oauth->getOAuth()->getAuthenticatedRequest(
            'POST', $url, $token, $options
        );

        try {
            $this->oauth->getOAuth()->getResponse($crestrequest);
        } catch (IdentityProviderException $e) {
            if ($e->getMessage() !== 'OK') {
                throw $e;
            }
        }
    }

    public function getLocation(Request $request, $userid)
    {
        $url = $this->crest . "characters/$userid/location/";
        return new EveLocation($this->getRequest($request, $url));
    }

    public function setWaypoint(Request $request, $userid, $waypoint, $reset=false)
    {
        $waypoint_json = [
            'solarSystem' => [
                'href' => $this->crest . "solarsystems/$waypoint/",
                'id' => (int) $waypoint
            ],
            'first' => false,
            'clearOtherWaypoints' => $reset
        ];

        $url = $this->crest. "characters/$userid/ui/autopilot/waypoints/";
        $this->postRequest($request, $url, $waypoint_json);
    }

    public function setWaypoints(Request $request, $userid, array $waypoints)
    {
        $reset = true;
        foreach ($waypoints as $waypoint) {
            $this->setWaypoint($request, $userid, $waypoint, $reset);
            $reset = false;
        }
    }

    public function getUserInfo(Request $request, $userid)
    {
        $url = $this->crest . "characters/$userid/";
        return new EveUser($this->getRequest($request, $url));
    }

    public function getUserStats(Request $request, $userid)
    {
        $url = Config::get('eveonline.stats-crest') . "$userid/";
        $stats = new EveUserStats($this->getRequest($request, $url));

        if (!$stats->isValid()) {
            throw new EveCRESTException($stats->getErrorMessage());
        }

        return $stats;
    }
}
