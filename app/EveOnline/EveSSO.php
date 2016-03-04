<?php

namespace App\EveOnline;

use Illuminate\Http\Request;

use Config;

class EveSSO
{
    private $oauth;

    function __construct(EveOAuthProviderInterface $oauth)
    {
        $this->oauth = $oauth;
    }

    public function getRedirectUrl(Request $request)
    {
        $options = [
            'scope' => Config::get('eveonline.scope')
        ];
        $authurl = $this->oauth->getOAuth()->getAuthorizationUrl($options);

        $request->session()->set('evessostate', $this->oauth->getOAuth()->getState());
        $request->session()->save();

        return $authurl;
    }

    public function getUserInfo(Request $request)
    {
        if (!$request->has('code')
         || !$request->has('state')
         || !$request->session()->has('evessostate')
         || ($request->input('state') !== $request->session()->pull('evessostate'))) {
            throw new EveSSOException('Unidentified authorization request.');
        }

        $token = $this->oauth->getOAuth()->getAccessToken('authorization_code', [
            'code' => $request->input('code')
        ]);

        $this->oauth->setToken($request, $token);

        return $this->oauth->getOAuth()->getResourceOwner($token);
    }
}
