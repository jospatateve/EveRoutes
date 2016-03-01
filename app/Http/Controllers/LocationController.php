<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Config;
use Session;

use Evelabs\OAuth2\Client\Provider\EveOnline;

class LocationController extends Controller
{
    private $evesso;

    function __construct()
    {
        $this->evesso = new EveOnline([
            'clientId'     => Config::get('eveonline.id'),
            'clientSecret' => Config::get('eveonline.secret'),
            'redirectUri'  => url(Config::get('eveonline.callback'))
        ]);
    }

    public function location()
    {
        if (!Auth::check())  {
            return Redirect::to('/')->with('message', 'User not logged on.');
        }
        if (!Session::has('evessotoken')) {
            return Redirect::to('/')->with('message', 'No sso token provided.');
        }

        $user = Auth::user();
        $token = Session::get('evessotoken');

        if ($token->hasExpired()) {
            $token = $this->evesso->getAccessToken('refresh_token', [
                'refresh_token' => $token->getRefreshToken();
            ]);
            Session::set('evessotoken', $token);
            Session::save();
        }

        $crestrequest = $this->evesso->getAuthenticatedRequest(
            'GET',
            Config::get('eveonline.crest').'characters/'.$user->userid.'/location/',
            $token->getToken()
        );
        $crestresponse = $this->evesso->getResponse($crestrequest);

        $location = $crestresponse->solarSystem->name;
        return view('welcome')->with('location', $location);
    }
}
