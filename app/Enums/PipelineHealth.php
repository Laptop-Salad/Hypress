<?php

namespace App\Enums;

enum PipelineHealth: int
{
    case Healthy = 1;
    case Degraded = 2;
    case Critical = 3;
    case Offline = 4;
    case Unknown = 5;

    public function display(): string {
        return str($this->name)->replace('_', ' ')->toString();
    }

    public static function tryFromName($name) {
        return match ($name) {
            'Healthy' => self::Healthy,
            'Degraded' => self::Degraded,
            'Critical' => self::Critical,
            'Offline' => self::Offline,
            'Unknown' => self::Unknown,
        };
    }
}
