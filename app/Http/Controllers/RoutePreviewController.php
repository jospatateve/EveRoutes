<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\EveRoute;
use App\EveSystem;

use App\EveOnline\EveOAuthProvider;
use App\EveOnline\EvePublicCREST;

use App\Dotlan\Dotlan;
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
            'from' => 'max:255|exists:eve_systems,name|notwh',
            'type' => 'in:0,1,2'
        ]);
 
        if (!$request->has('from')) {
            return view('routepreview.index')->with('route', $everoute);
        }

        $type = $request->type ?: 0;

        $waypoints = [];
        $waypointsraw = explode(';', $everoute->waypoints);
        $waypointids = array_filter($waypointsraw, 'strlen');

        $starttime = microtime(true);
        $dotlan = new Dotlan;
        $systemstovisit = [];
        $systemstovisit[] = $request->from;
        $waypointidnamemap = EveSystem::wherein('system_id', $waypointids)->pluck('name', 'system_id');
        foreach ($waypointids as $waypointid) {
            $systemstovisit[] = $waypointidnamemap[$waypointid];
        }
        $waypointnames = $dotlan->getRoute($type, $systemstovisit);
        $waypointnameidmap = EveSystem::wherein('name', array_unique($waypointnames))->pluck('system_id', 'name');
        foreach ($waypointnames as $waypointname) {
            $waypoints[] = $waypointnameidmap[$waypointname];
        }
        $totaltime = microtime(true) - $starttime;

        try {
            $eveoauth = new EveOAuthProvider;
            $evepubliccrest = new EvePublicCREST($eveoauth);
            $zkill = new ZKillboard;
            $kills = [];

            array_walk($waypoints, function(&$waypoint) use ($evepubliccrest, $zkill, &$kills) {
                $waypoint = $evepubliccrest->getSystem($waypoint);
                if (!array_key_exists($waypoint->getId(), $kills)) {
                    $kills[$waypoint->getId()]['latest'] = $zkill->getSystemLatestKill($waypoint->getId());
                    $kills[$waypoint->getId()]['hour'] = $zkill->getSystemKillsOneHour($waypoint->getId());
                }
            });

            return view('routepreview.index', [
                'systems' => $systemstovisit,
                'route' => $everoute,
                'waypoints' => $waypoints,
                'kills' => $kills,
                'time' => $totaltime
            ]);
        } catch (\Exception $e) {
            return view('routepreview.index', [
                'systems' => $systemstovisit,
                'route' => $everoute,
                'waypoints' => $waypoints,
                'time' => $totaltime,
                'exception' => $e->getMessage()
            ]);
        }
    }
}
