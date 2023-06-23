<?php


namespace App\Enums;


use phpseclib3\Math\PrimeField\Integer;

enum QuestionTypeEnum: int
{
    case TEST = 1;
    case QUESTION = 2;
}
