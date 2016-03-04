<?php

namespace App\EveOnline;

use Illuminate\Http\Request;

interface EveOAuthProviderInterface
{
    public function getOAuth();
    public function getToken(Request $request);
    public function setToken(Request $request, $token);
}
