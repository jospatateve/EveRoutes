<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\EveRoute;
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

        return view('everoutes.index', [
            'everoutes' => $this->everoutes->forUser($request->user()),
            'editroute' => $everoute
        ]);
    }

    public function loadwaypoints(Request $request, EveRoute $everoute)
    {
        $this->authorize($everoute);

        $waypoints = explode(';', $everoute->waypoints);

        $evecrest = new EveCREST($this->eveoauth);
        $evecrest->setWaypoints($request, Auth::user()->userid, $waypoints);

        return redirect('/routes');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'waypoints' => 'required'
        ]);

        $request->user()->everoutes()->create([
            'name' => $request->name,
            'waypoints' => $request->waypoints
        ]);

        return redirect('/routes');
    }

    public function update(Request $request, EveRoute $everoute)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'waypoints' => 'required'
        ]);

        $this->authorize($everoute);

        $everoute->update([
            'name' => $request->name,
            'waypoints' => $request->waypoints
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
