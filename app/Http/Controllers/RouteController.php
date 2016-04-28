<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;

use App\EveRoute;
use App\EveSystem;
use App\EveWaypointList;
use App\Repositories\EveRouteRepository;

use App\EveOnline\EveOAuthProvider;
use App\EveOnline\EveCREST;

class RouteController extends Controller
{
    protected $everoutes;
    private $eveoauth;

    function __construct(EveRouteRepository $everoutes)
    {
        $this->middleware('auth');
        $this->everoutes = $everoutes;
        $this->eveoauth = new EveOAuthProvider();
    }

    public function index(Request $request)
    {
        return view('everoutes.index', [
            'everoutes' => $this->everoutes->forUser($request->user())
        ]);
    }

    public function index_update(Request $request, EveRoute $everoute)
    {
        $this->authorize('update', $everoute);

        $waypoints = EveWaypointList::fromString($everoute->waypoints)->toArray();

        return view('everoutes.index', [
            'everoutes' => $this->everoutes->forUser($request->user()),
            'editroute' => $everoute,
            'editroutewaypoints' => $waypoints
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:eve_routes,name,NULL,id,user_id,'.Auth::user()->id,
            'waypoints.*' => 'required|distinct|exists:eve_systems,name|notwh'
        ]);

        $waypoints = EveWaypointList::fromArray($request->waypoints)->toString();
        $request->user()->everoutes()->create([
            'name' => $request->name,
            'waypoints' => $waypoints
        ]);

        return redirect('/routes');
    }

    public function paste(Request $request)
    {
        $waypointsdump = $request->waypointsdump ?: '';
        $waypointsraw = preg_split(
            '/\n|\r|\,|\s/', $waypointsdump,
            -1, PREG_SPLIT_NO_EMPTY
	    ) ?: [''];

        $request->merge(['waypoints' => $waypointsraw]);
        return $this->store($request);
    }

    public function update(Request $request, EveRoute $everoute)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:eve_routes,name,'.$everoute->id.',id,user_id,'.Auth::user()->id,
            'waypoints.*' => 'required|distinct|exists:eve_systems,name|notwh'
        ]);

        $this->authorize($everoute);

        $waypoints = EveWaypointList::fromArray($request->waypoints)->toString();
        $everoute->update([
            'name' => $request->name,
            'waypoints' => $waypoints
        ]);

        return redirect('/routes');
    }

    public function destroy(Request $request, EveRoute $everoute)
    {
        $this->authorize($everoute);

        $everoute->delete();
        return redirect('/routes');
    }
}
