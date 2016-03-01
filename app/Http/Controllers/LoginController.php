<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use Redirect;
use Session;

use Evelabs\OAuth2\Client\Provider\EveOnline;

use App\EveUser;

class LoginController extends Controller
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

    public function redirect()
    {
        $options = [
            'scope' => Config::get('eveonline.scope')
        ];
        $authurl = $this->evesso->getAuthorizationUrl($options);

        Session::set('evessostate', $this->evesso->getState());
        Session::save();

        return Redirect::to($authurl);
    }

    public function callback()
    {
        if (!Input::has('state')) {
            return Redirect::to('/')->with('message', 'Unidentified authorization request.');
        }

        $evessostate = Input::get('state');
        if (!Session::has('evessostate') || ($evessostate !== Session::get('evessostate'))) {
            return Redirect::to('/')->with('message', 'Unidentified authorization request.');
        }

        if (!Input::has('code')) {
            return Redirect::to('/')->with('message', 'Authorization request failed.');
        }
        $code = Input::get('code');

        $token = $this->evesso->getAccessToken('authorization_code', [
            'code' => $code
        ]);
        Session::set('evessotoken', $token);
        Session::save();

        try {
            $userinfo = $this->evesso->getResourceOwner($token);

            $user = new EveUser;
            $user->userid = $userinfo->getCharacterId();
            $user->name = $userinfo->getCharacterName();
            $user->owner = $userinfo->getCharacterOwnerHash();

            Auth::login($user);

            return Redirect::to('location');
        } catch (Exception $e) {
            return Redirect::to('/')->with('message', 'Failed to fetch user details.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
}
