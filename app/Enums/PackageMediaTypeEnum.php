<?php

namespace App\Enums;

enum PackageMediaTypeEnum
{
    const CUSTOMER_NIC_FRONT = 'CUSTOMER_NIC_FRONT';
    const CUSTOMER_NIC_BACK = 'CUSTOMER_NIC_BACK';
    const BENEFICIARY_NIC_FRONT = 'BENEFICIARY_NIC_FRONT';
    const BENEFICIARY_NIC_BACK = 'BENEFICIARY_NIC_BACK';
    const BENEFICIARY_PASSPORT = 'BENEFICIARY_PASSPORT';
    const NOMINEE_NIC_FRONT = 'NOMINEE_NIC_FRONT';
    const NOMINEE_NIC_BACK = 'NOMINEE_NIC_BACK';
    const OTHER_PROPOSAL_HARD_COPY = 'OTHER_PROPOSAL_HARD_COPY';


    public static function values(): array
    {
        return [
            self::CUSTOMER_NIC_FRONT,
            self::CUSTOMER_NIC_BACK,
            self::BENEFICIARY_NIC_FRONT,
            self::BENEFICIARY_NIC_BACK,
            self::BENEFICIARY_PASSPORT,
            self::NOMINEE_NIC_FRONT,
            self::NOMINEE_NIC_BACK,
            self::OTHER_PROPOSAL_HARD_COPY
        ];
    }
}
