<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\EveRoute;
use App\Repositories\EveRouteRepository;

class RouteController extends Controller
{
    protected $everoutes;

    function __construct(EveRouteRepository $everoutes)
    {
        $this->middleware('auth');
        $this->everoutes = $everoutes;
    }

    public function index(Request $request)
    {
        return view('everoutes.index', [
            'everoutes' => $this->everoutes->forUser($request->user())
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->everoutes()->create([
            'name' => $request->name,
        ]);

        return redirect('/routes');
    }

    public function destroy(Request $request, EveRoute $everoute)
    {
        $this->authorize('destroy', $everoute);
        $everoute->delete();
        return redirect('/routes');
    }
}
