<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use Illuminate\Http\Request;

use App\Models\Trip;

class TripController extends Controller
{
    //
   
    public function store(StoreTripRequest $request){
        $trips = [];


            // Decode each passenger JSON string
    $passengers = collect($request->input('passenger'))
    ->map(fn($p) => json_decode($p, true));

        $dest = $request->input('destination');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $place_id = $request->input('place_id');
        foreach ( $passengers as $passenger){
           $trips[] = Trip::create([
                'destination' => $dest,
                'place_id' => $place_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'passenger' => $passenger['name']
            ]);
        }

        return response()->json([
            'trips' => $trips
        ], 201);
    }
}
