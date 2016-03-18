<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\EveOnline\EveOAuthProvider;
use App\EveOnline\EveCREST;

class ProfileController extends Controller
{
    private $eveoauth;

    function __construct()
    {
        $this->middleware('auth');
        $this->eveoauth = new EveOAuthProvider();
    }

    public function index(Request $request)
    {
        try {
            $evecrest = new EveCREST($this->eveoauth);

            $userinfo = $evecrest->getUserInfo($request, Auth::user()->userid);
            $userstats = $evecrest->getUserStats($request, Auth::user()->userid);

            return view('profile.index', [
                'userinfo' => $userinfo,
                'userstats' => $userstats
            ]);
        } catch (\Exception $e) {
            return view('profile.index')->with('exception', $e->getMessage());
		}
    }
}
