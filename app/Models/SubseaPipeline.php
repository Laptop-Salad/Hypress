<?php

namespace App\Models;

use App\Enums\PipelineHealth;
use Illuminate\Database\Eloquent\Model;

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
}
