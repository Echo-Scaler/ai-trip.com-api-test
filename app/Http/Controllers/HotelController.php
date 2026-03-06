<?php

namespace App\Http\Controllers;

use App\Contracts\TripComApiContract;
use App\Models\Review;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct(
        protected TripComApiContract $tripComApi
    ) {}

    /**
     * Search for hotels.
     */
    public function search(Request $request)
    {
        $params = $request->validate([
            'city' => 'nullable|string|max:100',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date|after:check_in',
            'guests' => 'nullable|integer|min:1|max:10',
            'rooms' => 'nullable|integer|min:1|max:5',
        ]);

        $hotels = $this->tripComApi->searchHotels($params);

        return view('hotels.search', [
            'hotels' => $hotels,
            'params' => $params,
        ]);
    }

    /**
     * Show hotel detail page.
     */
    public function show(string $id)
    {
        $hotel = $this->tripComApi->getHotelDetail($id);

        if (!$hotel) {
            abort(404, 'Hotel not found');
        }

        // Fetch DB reviews for this hotel
        $reviews = Review::where('hotel_id', $id)->latest()->get();

        // Calculate dynamic rating and review counts based on DB if available, else fallback to API defaults
        if ($reviews->isNotEmpty()) {
            $hotel['rating'] = number_format($reviews->avg('rating'), 1);
            $hotel['review_count'] = $reviews->count();
        }

        return view('hotels.show', compact('hotel', 'reviews'));
    }
}
