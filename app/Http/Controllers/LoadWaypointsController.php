<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Response;

use App\EveRoute;

use App\EveOnline\EveOAuthProvider;
use App\EveOnline\EveCREST;

class LoadWaypointsController extends Controller
{
    private $eveoauth;

    function __construct()
    {
        $this->middleware('auth');
        $this->eveoauth = new EveOAuthProvider();
    }

    private function load_waypoints(Request $request, EveRoute $everoute)
    {
        $this->authorize('loadwaypoints', $everoute);

        $waypointsraw = explode(';', $everoute->waypoints);
        $waypoints = array_filter($waypointsraw, 'strlen');

        $evecrest = new EveCREST($this->eveoauth);
        $evecrest->setWaypoints($request, Auth::user()->userid, $waypoints);
    }

    public function loadwaypoints_json(Request $request, EveRoute $everoute)
    {
        try {
            $this->load_waypoints($request, $everoute);
            return Response::json(['loadedsuccess' => $everoute->name]);
        } catch (\Exception $e) {
            return Response::json(['exception' => $e->getMessage()], 500);
        }
    }

    public function loadwaypoints(Request $request, EveRoute $everoute)
    {
        try {
            $this->load_waypoints($request, $everoute);
            return back()->withInput()->with('loadedsuccess', $everoute->name);
        } catch (\Exception $e) {
            return back()->withInput()->with('exception', $e->getMessage());
        }
    }
}
