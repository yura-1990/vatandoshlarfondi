<?php

namespace App\Enums;

enum UniversityApplierAttachmentTypeEnum:string
{
    case PASSPORT = 'passport';
    case DIPLOMA= 'diploma';
    case PHOTO = 'photo';
    case OTHER = 'other';
}
