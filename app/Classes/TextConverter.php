<?php

namespace App\Classes;

class TextConverter
{

    public static function getDurationText(int $months): string
    {
        $years = $months % 12 == 0  ? $months / 12 : ceil($months / 12);
        return $years . ' ' . ($years > 1 ? 'years' : 'year');
    }
}
