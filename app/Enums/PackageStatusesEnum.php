<?php

namespace App\Enums;


enum PackageStatusesEnum
{
    const PROPOSAL_CREATED = 'PROPOSAL_CREATED';
    const SUBMITTED_FOR_SUPERVISOR = 'SUBMITTED_FOR_SUPERVISOR';
    const SUPERVISOR_REJECTED = 'SUPERVISOR_REJECTED';
    const SUPERVISOR_APPROVED = 'SUPERVISOR_APPROVED';
    const DOCUMENT_VERIFICATION = 'DOCUMENT_VERIFICATION';
    const DOCUMENT_REJECTED = 'DOCUMENT_REJECTED';
    const DOCUMENT_VERIFIED = 'DOCUMENT_VERIFIED';
    const AGREEMENT_PRINT = 'AGREEMENT_PRINT';
    const READY_TO_SIGN = 'READY_TO_SIGN';
    const SIGNED = 'SIGNED';
    const STARTED = 'STARTED';
    const MATURED = 'MATURED';
    const CANCELLED = 'CANCELLED';

    public static function values(): array
    {
        return [
            self::PROPOSAL_CREATED,
            self::SUBMITTED_FOR_SUPERVISOR,
            self::SUPERVISOR_REJECTED,
            self::SUPERVISOR_APPROVED,
            self::DOCUMENT_VERIFICATION,
            self::DOCUMENT_REJECTED,
            self::DOCUMENT_VERIFIED,
            self::AGREEMENT_PRINT,
            self::READY_TO_SIGN,
            self::SIGNED,
            self::STARTED,
            self::MATURED,
            self::CANCELLED
        ];
    }

    public static function valuesWithColors(): array
    {
        return [
            self::PROPOSAL_CREATED => '#3382f3',
            self::SUBMITTED_FOR_SUPERVISOR => '#007337',
            self::SUPERVISOR_REJECTED => '#f33333',
            self::SUPERVISOR_APPROVED => '#7F74D6',
            self::DOCUMENT_VERIFICATION => '#3eb709',
            self::DOCUMENT_REJECTED => '#f33333',
            self::DOCUMENT_VERIFIED => '#410EF5',
            self::AGREEMENT_PRINT => '#8209b7ba',
            self::READY_TO_SIGN => '#0e17ebba',
            self::SIGNED => '#08629f',
            self::STARTED => '#089f0b',
            self::MATURED => '#DB5125',
            self::CANCELLED => '#4492D6'
        ];
    }

    public static function getDBId(string $value): ?int
    {
        return 1;
    }
}
