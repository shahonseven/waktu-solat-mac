<?php

namespace App\Enums;

enum PrayerTime: string
{
    case FAJR = 'fajr';

    case SUNRISE = 'sunrise';

    case DHUHR = 'dhuhr';

    case ASR = 'asr';

    case MAGHRIB = 'maghrib';

    case ISHA = 'isha';

    public function label(): string
    {
        return match ($this) {
            self::FAJR => __('Fajr'),
            self::SUNRISE => __('Sunrise'),
            self::DHUHR => __('Dhuhr'),
            self::ASR => __('Asr'),
            self::MAGHRIB => __('Maghrib'),
            self::ISHA => __('Isha'),
        };
    }
}
