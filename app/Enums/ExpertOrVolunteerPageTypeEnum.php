<?php

namespace App\Enums;

enum ExpertOrVolunteerPageTypeEnum: int
{
    case EXPERT_BANNER = 1;
    case VOLUNTEER_BANNER = 2;
    case EXPERT_IN_DETAIL = 3;
    case VOLUNTEER_IN_DETAIL = 4;
}
