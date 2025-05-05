<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\User;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        //
       $review = Review::create($request->all());
       return $review;
    // $place_id = $request->place_id;
    // $review = new Review();

    // $average = $review->averageRating($place_id);
    // echo $average;
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //

        $user_reviews = $user->reviews()->with('place')->get();
        return response()->json($user_reviews);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
    public function rating($place){
        $review = new Review();

        $rating = $review->averageRating($place);

        return  response()->json([
            "rating" => $rating,
        ]);
      
    }
}
