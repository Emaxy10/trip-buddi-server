<?php

use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthouriseByRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;





Route::post('/register', [UserController::class,'register']);
Route::post('/login', [UserController::class,'login']);


// PLACES
Route::get('/places', [PlaceController::class,'index']);
Route::get('/places/{place}', [PlaceController::class,'show']);
Route::post('/places', [PlaceController::class,'store'])->middleware('auth:api')->middleware('role:admin');

Route::put('/places/{place}', [PlaceController::class,'update'])->middleware('auth:api')->middleware('role:admin')->middleware('permission:update place');
Route::delete('/places/{place}', [PlaceController::class,'destroy']);

//Review
Route::post('/review', [ReviewController::class,'store']);