<?php

use App\Http\Controllers\PlaceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;




Route::post('/register', [UserController::class,'register']);
    Route::post('/login', [UserController::class,'login']);

Route::get('/test', function () {
    return response()->json(['message' => 'Welcome to the API!']);
});





// PLACES
Route::get('/place', [PlaceController::class,'index']);
Route::post('/place', [PlaceController::class,'store']);
Route::put('/place/{place}', [PlaceController::class,'update']);
Route::delete('/place/{place}', [PlaceController::class,'destroy']);