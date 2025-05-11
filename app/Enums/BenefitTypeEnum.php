<?php

namespace App\Enums;

enum BenefitTypeEnum
{
    const MONTHLY_BENEFIT = 'MONTHLY_BENEFIT';
    const PROFIT = 'PROFIT';
    const MATURITY = 'MATURITY';
    const CAPITAL = 'CAPITAL';

    public static function values(): array
    {
        return [
            self::MONTHLY_BENEFIT,
            self::PROFIT,
            self::MATURITY,
            self::CAPITAL
        ];
    }

}
