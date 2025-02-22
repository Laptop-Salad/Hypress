<?php

namespace App\Enums;

use App\Models\PointsOfInterest;
use App\Models\SubseaAsset;
use App\Models\SubseaPipeline;
use App\Models\SurfVessel;

enum AssetType: int
{
    case Point_Of_Interest = 1;
    case Subsea_Pipeline = 2;
    case Subsea_Asset = 3;
    case Surf_Vessel = 4;

    public function display(): string {
        return str($this->name)->replace('_', ' ')->toString();
    }

    public function icon(): string {
        return match ($this) {
            self::Point_Of_Interest => 'fa-solid fa-location-dot',
            self::Subsea_Pipeline => 'fa-solid fa-pipe-section',
            self::Subsea_Asset => 'fa-solid fa-container-storage',
            self::Surf_Vessel => 'fa-solid fa-ship',
        };
    }

    public static function fromClass($class) {
        return match ($class) {
            PointsOfInterest::class => self::Point_Of_Interest,
            SubseaPipeline::class => self::Subsea_Pipeline,
            SubseaAsset::class => self::Subsea_Asset,
            SurfVessel::class => self::Surf_Vessel,
        };
    }
}
