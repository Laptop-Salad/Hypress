<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Alert extends Model
{
    protected $guarded = ['id'];

    public function alertable(): MorphTo {
        return $this->morphTo();
    }
}
