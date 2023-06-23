<?php


namespace App\Enums;


use phpseclib3\Math\PrimeField\Integer;

enum FamilyStatusEnum: int
{
    case SINGLE = 1;
    case MARRIED = 2;
    case DIVORCED = 3;
}
