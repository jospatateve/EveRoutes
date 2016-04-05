<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\EveRoute;
use App\EveSystem;

use App\EveOnline\EveMap;

class RoutePreviewController extends Controller
{
    private $eveoauth;

    function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, EveRoute $everoute)
    {
        $this->authorize('loadwaypoints', $everoute);
        $this->validate($request, [
            'from' => 'max:255|exists:eve_systems,name|notwh'
        ]);
 
        if (!$request->has('from')) {
            return view('routepreview.index')->with('route', $everoute);
        }

        $waypoints = [];
        $waypointsraw = explode(';', $everoute->waypoints);
        $waypointids = array_filter($waypointsraw, 'strlen');
        $from = EveSystem::where('name', $request->from)->first()->system_id;

        foreach ($waypointids as $waypoint) {
            $waypoints[] = EveMap::shortestPath($from, $waypoint);
            $from = $waypoint;
        }

        array_walk_recursive($waypoints, function(&$waypoint) {
            $system = EveSystem::where('system_id', "$waypoint")->first();
            $waypoint = $system->name;
        });

        return view('routepreview.index', [
            'route' => $everoute,
            'waypoints' => $waypoints
        ]);
    }
}
