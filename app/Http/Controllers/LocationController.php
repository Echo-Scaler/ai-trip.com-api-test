<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LocationController extends Controller
{
    /**
     * Get location suggestions based on query.
     */
    public function suggest(Request $request)
    {
        $query = strtolower($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $path = resource_path('data/locations.json');

        if (!File::exists($path)) {
            return response()->json([]);
        }

        $locations = json_decode(File::get($path), true);

        $results = collect($locations)->filter(function ($location) use ($query) {
            return str_contains(strtolower($location['name']), $query) ||
                str_contains(strtolower($location['code']), $query);
        })->values()->take(8);

        return response()->json($results);
    }
}
