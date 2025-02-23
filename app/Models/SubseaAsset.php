<?php

namespace App\Models;

use App\Enums\PipelineHealth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SubseaAsset extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'coordinates' => 'json',
        'last_inspection' => 'date',
        'next_maintenance' => 'date',
        'health' => PipelineHealth::class,
    ];

    public function alerts(): MorphMany {
        return $this->morphMany(Alert::class, 'alertable');
    }

    public function connectedToAssets(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'connected_subsea_assets',
            'connected_asset_id',             // Foreign key for this model
            'subsea_asset_id'                 // Foreign key for the related model
        );
    }
}
