<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Exception;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'rating' => 'required',
        ]);

        try {

            $rating = new Rating;

            $rating->product_id = $request->product_id;
            $rating->rating = $request->rating;
          
            $rating->save();

            return response()->json(['message' => 'Thanks to give us ratings!'], 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
