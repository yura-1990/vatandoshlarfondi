<?php


namespace App\Enums;


use phpseclib3\Math\PrimeField\Integer;

enum ChatRoomJoinRequestStatusEnum: int
{
    case PENDING = 1;
    case ACCEPTED = 10;
    case REJECTED = 0;
}
