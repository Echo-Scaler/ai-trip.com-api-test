<?php

namespace App\Http\Controllers;

use App\Contracts\TripComApiContract;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        protected TripComApiContract $tripComApi
    ) {}

    /**
     * Display the home page with search form.
     */
    public function index()
    {
        // Get a few featured hotels and flights for the homepage
        $featuredHotels = array_slice($this->tripComApi->searchHotels([])->items(), 0, 3);
        $featuredFlights = array_slice($this->tripComApi->searchFlights([])->items(), 0, 3);

        return view('home', compact('featuredHotels', 'featuredFlights'));
    }
}
