<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Auth;
use Redirect;

use App\EveOnline\EveOAuthProvider;
use App\EveOnline\EveSSO;
use App\EveOnline\EveUserFactory;
use App\User;

class LoginController extends Controller
{
    private $eveoauth;

    function __construct()
    {
        $this->eveoauth = new EveOAuthProvider();
    }

    public function redirect(Request $request)
    {
        $evesso = new EveSSO($this->eveoauth);
        $authurl = $evesso->getRedirectUrl($request);
        return Redirect::to($authurl);
    }

    public function callback(Request $request)
    {
        $evesso = new EveSSO($this->eveoauth);

        try {
            $userinfo = $evesso->getUserInfo($request);
            $user = User::where('userid', '=', $userinfo->getCharacterId())->first();

            if (empty($user)) {
                $user = EveUserFactory::create($userinfo);
            } else if ($user->owner !== $userinfo->getCharacterOwnerHash()) {
                // character was transferred to new owner
                $user = EveUserFactory::reset($user, $userinfo);
            }

            Auth::login($user);

            return Redirect::to('/routes');
        } catch (\Exception $e) {
            return Redirect::to('/')->with('exception', $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
}
