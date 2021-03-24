<?php

namespace App\Http\Helper;

class Helper
{
    /**
     * @param string $gender
     * @return string
     */
    public static function getGenderWord(string $gender)
    {
        if(strtolower($gender) === 'f')
        {
            return 'Female';
        } if(strtolower($gender) === 'm')
    {
        return 'Male';
    } if(strtolower($gender) === 'o')
    {
        return 'Other';
    }
        return '-';
    }
}
