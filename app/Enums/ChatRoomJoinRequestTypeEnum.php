<?php


namespace App\Enums;


use phpseclib3\Math\PrimeField\Integer;

enum ChatRoomJoinRequestTypeEnum: int
{
    case PRIVATE = 1;
    case GROUP = 2;
}
