<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Show the booking form.
     */
    public function create(Request $request)
    {
        $bookingData = [
            'type' => $request->input('type', 'hotel'),
            'item_name' => $request->input('item_name', ''),
            'item_id' => $request->input('item_id', ''),
            'price' => $request->input('price', 0),
            'currency' => $request->input('currency', 'USD'),
            'details' => $request->input('details', ''),
        ];

        return view('booking.create', compact('bookingData'));
    }

    /**
     * Process the booking (demo).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:hotel,flight',
            'item_id' => 'required|string',
            'item_name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Generate a demo booking reference
        $bookingRef = strtoupper('TC' . date('ymd') . rand(1000, 9999));

        return view('booking.success', [
            'booking' => $validated,
            'bookingRef' => $bookingRef,
        ]);
    }
}
