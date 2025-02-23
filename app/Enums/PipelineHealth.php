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

    public function icon() {
        return match ($this) {
            self::Healthy => 'fa-regular fa-wave-pulse',
            self::Degraded => 'fa-solid fa-wine-glass-crack',
            self::Critical => 'fa-solid fa-exclamation-triangle',
            self::Offline => 'fa-solid fa-user-robot-xmarks',
            self::Unknown => 'fa-solid fa-question',
        };
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
