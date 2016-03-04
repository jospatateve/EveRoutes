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
        $evecrest = new EveCREST($this->eveoauth);
        $userinfo = $evecrest->getUserInfo($request, Auth::user()->userid);
        return view('profile.index')->with('userinfo', $userinfo);
    }
}
