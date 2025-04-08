<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    //
    protected $fillable = [
        "name",
        "description",
        "category",
        "rating",
        "location",
        "address",
        "budget",
        "image",
    ];

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function favourites(){
        return $this->hasMany(Favourite::class);
    }
}
