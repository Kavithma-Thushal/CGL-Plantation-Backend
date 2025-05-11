<?php

namespace App\Enums;

enum PaymentMethodsEnum
{
    const CASH = 'CASH';
    const BANK = 'BANK';
    const TRANSFER = 'TRANSFER';

    public static function values(): array
    {
        return [
            self::CASH,
            self::BANK,
            self::TRANSFER
        ];
    }
}
