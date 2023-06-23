<?php

namespace App\Enums;

use phpseclib3\Math\PrimeField\Integer;

enum UniversityApplierStatusEnum:int
{
    case NEW = 1;
    case SEND_TO_UNIVERSITY= 10;
    case REJECTED = 0;
}
