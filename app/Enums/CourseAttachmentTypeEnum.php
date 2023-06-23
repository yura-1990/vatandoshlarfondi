<?php


namespace App\Enums;


use phpseclib3\Math\PrimeField\Integer;

enum CourseAttachmentTypeEnum: int
{
    case VIDEO = 1;
    case AUDIO = 2;
    case PHOTO = 3;
    case DOCUMENT = 4;
}
