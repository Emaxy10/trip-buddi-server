<?php

use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthouriseByRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;




//USER
Route::post('/register', [UserController::class,'register']);
Route::post('/login', [UserController::class,'login']);
Route::get('/users',[UserController::class, 'index']);


// PLACES
Route::get('/places', [PlaceController::class,'index']);
// ->middleware('auth:api')
// ->middleware('ensure.valid.access.token');
//DELETE
Route::delete('places/{place}',[PlaceController::class,'delete']);

Route::get('/places/{place}', [PlaceController::class,'show']);
Route::post('/places', [PlaceController::class,'store']);
Route::get('/places/{place}/review', [PlaceController::class,'review']);
// ->middleware('auth:api')->middleware('role:admin'); 

//Update
Route::put('/places/{place}', [PlaceController::class,'update'])
    ->middleware('auth:api')
    ->middleware('ensure.valid.access.token');
// ->middleware('role:admin')->middleware('permission:update place');
Route::delete('/places/{place}', [PlaceController::class,'destroy']);

//Review
Route::post('/review', [ReviewController::class,'store']);
Route::get('/places/{user}/reviews', [ReviewController::class,'show']);

//Rating
Route::get('/places/{place}/rating', [ReviewController::class,'rating']);

//Favourites
Route::post('/places/favourite', [FavouriteController::class, 'store']);
Route::get('/places/{user}/favourite', [FavouriteController::class, 'show']);

//Search
Route::get('/places/search/{search}', [PlaceController::class, 'search']);
