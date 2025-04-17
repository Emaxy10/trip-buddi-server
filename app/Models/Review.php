<?php

namespace App\Models;

use App\Http\Controllers\ReviewController;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = [
         'user_id',
        'place_id',
        'rating',
        'comment'
    ] ;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function place(){
        return $this->belongsTo(Place::class);
    }

    public function averageRating($place){
        $averageRating = self::where('place_id', $place)->avg('rating');
        return round($averageRating, 1);
    }
}
