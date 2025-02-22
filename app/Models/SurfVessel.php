<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurfVessel extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'eta' => 'datetime',
        'last_inspection' => 'date',
        'coordinates' => 'json',
    ];
}
