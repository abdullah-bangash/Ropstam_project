<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Exception;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'reviews' => 'required',
        ]);

        try {

            $review = new Review;

            $review->product_id = $request->product_id;
            $review->reviews = $request->reviews;
          
            $review->save();

            return response()->json(['message' => 'Thanks to give us reviews!'], 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
