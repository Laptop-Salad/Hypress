<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SurfVessel extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'eta' => 'datetime',
        'last_inspection' => 'date',
        'coordinates' => 'json',
    ];

    public function alerts(): MorphMany {
        return $this->morphMany(Alert::class, 'alertable');
    }
}
