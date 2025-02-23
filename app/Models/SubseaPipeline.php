<?php

namespace App\Models;

use App\Enums\PipelineHealth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SubseaPipeline extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'start_coordinates' => 'json',
        'end_coordinates' => 'json',
        'last_inspection' => 'date',
        'next_maintenance' => 'date',
        'health' => PipelineHealth::class
    ];

    public function alerts(): MorphMany {
        return $this->morphMany(Alert::class, 'alertable');
    }
}
