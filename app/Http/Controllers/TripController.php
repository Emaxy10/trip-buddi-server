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

        $passengers = collect($request->input('passenger'))
                        ->map(fn($p) => json_decode($p, true));

        $dest = $request->input('destination');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $place_id = $request->input('place_id');

        foreach ($passengers as $passenger) {
            // Check if trip already exists
            $existingTrip = Trip::where('passenger', $passenger['name'])
                ->where('place_id', $place_id)
                ->where('start_date', $start_date)
                ->where('end_date', $end_date)
                ->first();

            if (!$existingTrip) {
                // Create new trip
                $trips[] = Trip::create([
                    'destination' => $dest,
                    'place_id' => $place_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'passenger' => $passenger['name'],

                    
                ]);

                 return response()->json([
                'trips' => $trips
        ], 201);
            } else {
                 return response()->json([
                    'error' => "Trip already exists for passenger "
                ], );
            }
        }

       
    }
}
