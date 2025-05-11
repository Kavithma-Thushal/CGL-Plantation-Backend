<?php

namespace App\Classes;

class CodeGenerator
{
    public static function getCustomerCode(): string
    {
        return 'OPUSKFNL49';
    }

    public static function getRandom($length = 6)
    {
        $characters = '123456789';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }
        return $code;
    }
   
    public static function getPackageCode($length = 6)
    {
        $characters = '123456789';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }
        return $code;
    }

    public static function getUniqueCharacter($length)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }
        return $code;
    }

    public static function getCodeByName($name)
    {
        // Remove any non-alphabetic characters
        $name = preg_replace('/[^A-Za-z]/', '', $name);

        // Convert the name to uppercase
        $name = strtoupper($name);

        // If the name is less than three letters, pad it with X's
        if (strlen($name) < 3) {
            return str_pad($name, 3, 'X');
        }

        // Otherwise, take the first three letters
        return substr($name, 0, 3);
    }

    public static function generateEmployeeCode(string $employeeEpf,string $branchCode) : string
    {
        return $branchCode . '-' . $employeeEpf;
    }
  
    public static function generateQuotationNumber(int $quotationId) : string
    {
        return 'QT-'. str_pad($quotationId, 6, '0', STR_PAD_LEFT);
    }
}
