<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavouriteRequest;
use App\Models\Favourite;
use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function show(User $user)
    {
        //
        $user_favourites = $user->favourites()->with('place')->get();
        $places = $user_favourites->map(function ($favourite) {
            $place = $favourite->place;
        
            return [
                "id" => $place->id,
                "name" => $place->name,
                "category" => $place->category,
                "description" => $place->description,
                "address" => $place->address,
                "rating" => $place->rating,
                "image" => asset("images/" . $place->image),
            ];
        });
        
        return response()->json($places);
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
