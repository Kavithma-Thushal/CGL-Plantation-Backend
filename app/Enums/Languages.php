<?php

namespace App\Enums;

enum Languages
{
    const ENGLISH = 'en';
    const SINHALA = 'si';

    public static function values(): array
    {
        return [
            self::ENGLISH,
            self::SINHALA
        ];
    }
}
