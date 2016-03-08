<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\EveOnline\EveOAuthProvider;
use App\EveOnline\EveCREST;

class LocationController extends Controller
{
    private $eveoauth;

    function __construct()
    {
        $this->middleware('auth');
        $this->eveoauth = new EveOAuthProvider();
    }

    public function location(Request $request)
    {
        try {
            $evecrest = new EveCREST($this->eveoauth);
            $location = $evecrest->getLocation($request, Auth::user()->userid);

            if ($location->isValid()) {
                return redirect()->action('SystemController@search', ['name' => $location->getName()]);
            }

            return view('location.index');
        } catch (\Exception $e) {
			return view('location.index')->with('exception', $e->getMessage());
        }
    }
}
