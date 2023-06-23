<?php

namespace App\Enums;

enum DictionaryKeyEnum:string
{
    case SPECIALITY = 'speciality';
    case EDUCATION_LEVEL ='education_level';
    case JOB_SKILLS = 'job_skills';
    case LANGUAGES = 'languages';
    case LANGUAGES_LEVEL = 'languages_level';
    case EMPLOYMENT_TYPE = 'employment_type';
    case SCHEDULE_TYPE = 'schedule_type';
    case FAMILY_STATUS = 'family_status';
    case COURSE_LEVEL = 'course_level';
}
