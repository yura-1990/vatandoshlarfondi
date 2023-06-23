<?php

namespace App\Enums;

enum CommunityApplicationStatusEnum:int
{
    case NEW = 1;
    case ACCEPTED= 10;
    case NOT_ACCEPTED = 0;
}
