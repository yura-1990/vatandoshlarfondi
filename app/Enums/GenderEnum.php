<?php


namespace App\Enums;


use phpseclib3\Math\PrimeField\Integer;

enum GenderEnum: int
{
    case MALE = 1;
    case FEMALE = 2;
    case OTHER = 3;
}
