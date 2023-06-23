<?php


namespace App\Enums;


use phpseclib3\Math\PrimeField\Integer;

enum CourseTypeEnum: int
{
    case VIDEO = 1;
    case AUDIO = 2;
}
