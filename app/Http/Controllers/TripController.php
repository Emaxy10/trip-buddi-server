<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use Illuminate\Http\Request;

use App\Models\Trip;
use App\Models\User;

class TripController extends Controller
{
    //
   
    public function store(StoreTripRequest $request){
        //     $trips = [];

        // $passengers = collect($request->input('passenger'));
        //                 // ->map(fn($p) => json_decode($p, true));

        // $dest = $request->input('destination');
        // $start_date = $request->input('start_date');
        // $end_date = $request->input('end_date');
        // $place_id = $request->input('place_id');
        // $user_id = $request->input('user_id');

        // foreach ($passengers as $passenger) {
        //     echo $passenger['name'];
        //     // Check if trip already exists
        //     $existingTrip = Trip::where('passenger_name', $passenger['name'])
        //         ->where('place_id', $place_id)
        //         ->where('start_date', $start_date)
        //         ->where('end_date', $end_date)
        //         ->first();

        //     if (!$existingTrip) {
        //         // Create new trip
        //         $trips[] = Trip::create([
        //             'user_id'=> $user_id,
        //             'destination' => $dest,
        //             'place_id' => $place_id,
        //             'start_date' => $start_date,
        //             'end_date' => $end_date,
        //             'passenger_name' => $passenger['name'],

                    
        //         ]);

        //          return response()->json([
        //         'trips' => $trips
        // ], 201);
        //     } else {
        //          return response()->json([
        //             'error' => "Trip already exists for passenger "
        //         ], );
        //     }
        // }


        
        $trips = [];
        $skipped = [];

        $passengers = collect($request->input('passenger'))
        ->map(fn($p) => json_decode($p, true));

        $dest = $request->input('destination');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $place_id = $request->input('place_id');
        $user_id = $request->input('user_id');

        foreach ($passengers as $passenger) {
            // Optional: Log the name if needed
            // \Log::info('Processing passenger: '.$passenger['name']);

            // Check if trip already exists
            $existingTrip = Trip::where('passenger_name', $passenger['name'])
                ->where('place_id', $place_id)
                ->where('start_date', $start_date)
                ->where('end_date', $end_date)
                ->first();

            if (!$existingTrip) {
                // Create new trip
                $trips[] = Trip::create([
                    'user_id' => $user_id,
                    'destination' => $dest,
                    'place_id' => $place_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'passenger_name' => $passenger['name'],
                ]);
            } else {
                // Skip duplicate
                $skipped[] = $passenger['name'];
            }
        }

        // Return response AFTER the loop — process all passengers first
        return response()->json([
            'trips' => $trips,
            'skipped_passengers' => $skipped,
        ], 201);
    }

    public function get_trip(User $user){
        
        $trips = $user->trips;

    }
}
