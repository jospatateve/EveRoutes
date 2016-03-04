<?php

namespace App\EveOnline;

use Illuminate\Http\Request;

class EveOAuthProvider implements EveOAuthProviderInterface
{
    private $eveoauth;

    function __construct()
    {
        $this->eveoauth = EveOAuthFactory::create();
    }

    public function getOAuth()
    {
        return $this->eveoauth;
    }

    public function getToken(Request $request)
    {
        if (!$request->session()->has('evessotoken')) {
            throw EveSSOException('No sso token provided.');
        }

        return $request->session()->get('evessotoken');
    }

    public function setToken(Request $request, $token)
    {
        $request->session()->put('evessotoken', $token);
        $request->session()->save();
    }
}
