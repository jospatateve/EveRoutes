<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\EveRoute;
use App\EveSystem;

use App\EveOnline\EveMap;
use App\EveOnline\EveOAuthProvider;
use App\EveOnline\EvePublicCREST;

use App\ZKillboard\ZKillboard;

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

        $starttime = microtime(true);
        foreach ($waypointids as $waypoint) {
            $waypoints[] = EveMap::shortestPath($from, $waypoint);
            $from = $waypoint;
        }
        $totaltime = microtime(true) - $starttime;

        try {
            $eveoauth = new EveOAuthProvider;
            $evepubliccrest = new EvePublicCREST($eveoauth);
            $zkill = new ZKillboard;
            $kills = [];
     
            array_walk_recursive($waypoints, function(&$waypoint) use ($evepubliccrest, $zkill, &$kills) {
                $waypoint = $evepubliccrest->getSystem($waypoint);
                if (!array_key_exists($waypoint->getId(), $kills)) {
                    $kills[$waypoint->getId()] = $zkill->getSystemKillsOneHour($waypoint->getId());
                }
            });

            return view('routepreview.index', [
                'route' => $everoute,
                'waypoints' => $waypoints,
                'kills' => $kills,
                'time' => $totaltime
            ]);
        } catch (\Exception $e) {
            return view('routepreview.index', [
                'route' => $everoute,
                'waypoints' => $waypoints,
                'time' => $totaltime,
                'exception' => $e->getMessage()
            ]);
        }
    }
}
