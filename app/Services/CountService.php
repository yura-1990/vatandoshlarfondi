<?php

namespace App\Services;

class CountService
{
    public static function countExperiences($start, $finish): float
    {
        return $finish
            ? floor(abs(strtotime($start) - strtotime($finish)) / (365*60*60*24))
            : floor(abs(strtotime($start) - strtotime(date('Y-m-d'))) / (365*60*60*24));
    }
}
