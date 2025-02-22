<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointsOfInterest extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'coordinates' => 'json'
    ];
}
