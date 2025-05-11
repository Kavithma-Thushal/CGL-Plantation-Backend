<?php

namespace App\Classes;



class NICConverter
{

    public static function getOldFormat(string $nic): ?string
    {
        return $nic;
    }

    public static function getNewFormat(string $nic): ?string
    {
        return $nic;
    }
   
    public static function getDOB(string $nic): ?string
    {
        return '2020-02-01';
    }

    public static function validate($nic)
    {
        // Check if the NIC number matches the old format (XXXXXXXXXV)
        if (preg_match('/^[0-9]{9}[vV]$/', $nic)) {
            return true;
        }

        // Check if the NIC number matches the new format (XXXXXXXXXXXX)
        if (preg_match('/^[0-9]{12}$/', $nic)) {
            return true;
        }

        // If neither format matches, the NIC number is invalid
        return false;
    }
}
