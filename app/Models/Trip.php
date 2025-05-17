<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        "name",
        "destination",
        "start_date",
        "end_date",
        "passenger"
    ];
}
