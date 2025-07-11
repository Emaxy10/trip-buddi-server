<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $places = Place::all();
        $placesData = $places->map(function ($place) {
            return [
                "id"=> $place->id,
                "name"=> $place->name,
                "category" => $place->category,
                "description" => $place->description,
                "image" => asset("images/" . $place->image),
            ];
        });
       
        return response()->json($placesData);
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
    public function store(StorePlaceRequest $request)
    {
        //
       
        // $place = Place::create($request->all());
        // return $place;
        $image = $request->file("image");

        $folderName = Str::random(24); // Generates a 24-character random string
        
        $folderPath = public_path("images/$folderName");

          // Check if the folder doesn't exist, then create it
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true); // 0755 = permission, true = recursive creation
        }

        // Get original filename
        $filename = $image->getClientOriginalName();

        // Move the image to the new folder
        $image->move($folderPath, $filename);
        $place = new Place();

        $path = "$folderName/$filename";

        // dd($path);

       $place->create([
            "name"=> $request->input('name'),
            "description" => $request->input("description"),
            "category" => $request->input("category"),
            "rating" => $request->input("rating"),
            "address" => $request->input("address"),
            "image" => $path
        ]);



    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        //
        return response()->json([
            "id"=> $place->id,
            "name"=> $place->name,
            "category" => $place->category,
            "description" => $place->description,
            "address" => $place->address,
            "rating" => $place->rating,
            "image" => asset("images/" . $place->image),
        ]);

        //  get object and its relationship
        //  $placeReviews= Place::with('reviews.user')->find($place);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Place $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlaceRequest $request, Place $place)
    {
        //
         $place->update([
            "name"=> $request->input("name"),
            "description"=> $request->input("description"),
            "category"=> $request->input("category"),
            "address" => $request->input("address")
         ]);

         return response()->json([
            'message' => 'Place updated successfully',
            'place' => $place
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        //
       return  $place->delete();
    }

    public function review(Place $place){
       $placeReviews= $place->reviews()->with('user')->get();
       return response()->json( $placeReviews);
    }

    public function search($search){

        $places = Place::where('name', 'like', "%{$search}%")
        ->orWhere('category', 'like', "%{$search}%")
        ->orWhere('address', 'like', "%{$search}%" )
        ->get()
        ->map(function($place){
            return [
                "id" => $place->id,                         // Extracting the 'id' from each place
                "name" => $place->name,                     // Extracting the 'name' from each place
                "category" => $place->category,             // Extracting the 'category'
                "description" => $place->description,       // Extracting the 'description'
                "address" => $place->address,               // Extracting the 'address'
                "rating" => $place->rating,                 // Extracting the 'rating'
                "image" => asset("images/" . $place->image), // Adding the 'asset' URL to the 'image' path
            ];
        });

        // map() function is used to transform each item in a collection. 
        // In his case, it's being used to iterate through each $place object, 
        // extract specific properties, and apply transformations (such as adding the asset URL for the image).

        return response()->json($places);
    }
}
