<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavouriteRequest;
use App\Models\Favourite;
use App\Models\Place;
use Illuminate\Http\Request;

class FavouriteController extends Controller
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
    public function store( StoreFavouriteRequest $request)
    {
        //
        $favourite = new Favourite();
        $user_id =  $request->input('user_id');
        $place_id = $request->input('place_id');

        $fav = $favourite->where('user_id', $user_id)
                       ->where('place_id', $place_id)->first();

        if( $fav === null){
            
            return 
                $favourite->create([
                    "user_id" => $request->input('user_id'),
                    "place_id" => $request->input('place_id'),
                ]);
        }else{
            return response()->json(['message' => 'Already a favourite'], 200);
        }

    //    return 
    //     $favourite->create([
    //         "user_id" => $request->input('user_id'),
    //         "place_id" => $request->input('place_id'),
    //     ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Favourite $favourite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favourite $favourite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favourite $favourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favourite $favourite)
    {
        //
    }
}
