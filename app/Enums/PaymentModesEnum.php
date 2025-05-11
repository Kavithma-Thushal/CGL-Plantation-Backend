<?php

namespace App\Enums;

enum PaymentModesEnum
{
    const YEARLY = 'YEARLY';
    const HALF_YEAR = 'HALF_YEAR';
    const QUARTERLY = 'QUARTERLY';
    const MONTHLY = 'MONTHLY';
    const SINGLE = 'SINGLE';

    public static function values(): array
    {
        return [
            self::YEARLY,
            self::HALF_YEAR,
            self::QUARTERLY,
            self::MONTHLY,
            self::SINGLE
        ];
    }
}
