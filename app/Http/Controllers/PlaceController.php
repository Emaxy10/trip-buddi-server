<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Models\Place;
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
        return $places;
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

        $path = "images/$folderName/$filename";

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
         $place->update($request->all());

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
        $place->delete();
    }
}
