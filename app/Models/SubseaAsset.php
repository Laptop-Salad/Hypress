<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubseaAsset extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'coordinates' => 'json',
        'last_inspection' => 'date',
        'next_maintenance' => 'date'
    ];
}
