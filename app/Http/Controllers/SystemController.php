<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;

use App\EveSystem;
use App\EveOnline\EveOAuthProvider;
use App\EveOnline\EvePublicCREST;

class SystemController extends Controller
{
    public function autocomplete(Request $request)
    {
        $term = $request->input('term') ?: '';

        $results = [];

        $systems = EveSystem::where('name', 'LIKE', $term.'%')->take(5)->get();
        foreach ($systems as $system) {
            $results[] = [
                'id' => $system->id,
                'value' => $system->name
            ];
        }

        return Response::json($results);
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'name' => 'max:255|exists:eve_systems,name'
        ]);

        try {
            if ($request->has('name')) {
                $system = EveSystem::where('name', '=', $request->name)->first();

                $eveoauth = new EveOAuthProvider();
                $evepubliccrest = new EvePublicCREST($eveoauth);
                $systeminfo = $evepubliccrest->getSystem((int) $system->system_id);

                return view('system.index')->with('system', $systeminfo);
            }

        return view('system.index');
        } catch (\Exception $e) {
			return view('system.index')->with('exception', $e->getMessage());
        }
    }
}
