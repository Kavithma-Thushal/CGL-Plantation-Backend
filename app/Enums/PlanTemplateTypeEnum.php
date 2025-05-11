<?php

namespace App\Enums;

enum PlanTemplateTypeEnum
{
    const INVESTMENT = 'INVESTMENT';
    const SAVING = 'SAVING';

    public static function getValue($value): string
    {
        return match ($value) {
            self::INVESTMENT => 'INVESTMENT',
            self::SAVING => 'SAVING',
            default => 'UNKNOWN',
        };
    }

}
