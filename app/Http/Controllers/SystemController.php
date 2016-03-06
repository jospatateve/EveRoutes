<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;

use App\EveSystem;

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
}
