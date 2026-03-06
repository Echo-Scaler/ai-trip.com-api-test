<?php

namespace App\Http\Controllers;

use App\Contracts\TripComApiContract;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function __construct(
        protected TripComApiContract $tripComApi
    ) {}

    /**
     * Search for flights.
     */
    public function search(Request $request)
    {
        $params = $request->validate([
            'origin' => 'nullable|string|max:100',
            'destination' => 'nullable|string|max:100',
            'departure_date' => 'nullable|date',
            'return_date' => 'nullable|date|after_or_equal:departure_date',
            'passengers' => 'nullable|integer|min:1|max:9',
            'cabin_class' => 'nullable|string|in:Economy,Business,First',
        ]);

        $flights = $this->tripComApi->searchFlights($params);

        return view('flights.search', [
            'flights' => $flights,
            'params' => $params,
        ]);
    }

    /**
     * Show flight detail page.
     */
    public function show(string $id)
    {
        $flight = $this->tripComApi->getFlightDetail($id);

        if (!$flight) {
            abort(404, 'Flight not found');
        }

        return view('flights.show', compact('flight'));
    }
}
