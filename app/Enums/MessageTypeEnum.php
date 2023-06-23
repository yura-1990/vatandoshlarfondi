<?php


namespace App\Enums;


use phpseclib3\Math\PrimeField\Integer;

enum MessageTypeEnum: int
{
    case TEXT = 1;
    case IMAGE = 2;
    case VIDEO = 3;
    case AUDIO = 4;
}
