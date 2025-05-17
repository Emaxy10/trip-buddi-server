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
        $passengers = $request->input('passenger');
        $dest = $request->input('destination');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        foreach ( $passengers as $passenger){
           $trips[] = Trip::create([
                'destination' => $dest,
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
