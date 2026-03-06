<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a new guest review for a hotel.
     */
    public function store(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:255',
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'required|string|max:1000',
        ]);

        Review::create([
            'hotel_id'  => $id,
            'user_name' => $validated['user_name'],
            'rating'    => $validated['rating'],
            'comment'   => $validated['comment'],
        ]);

        return redirect()->back()->with('success', 'Your review has been posted successfully!');
    }
}
