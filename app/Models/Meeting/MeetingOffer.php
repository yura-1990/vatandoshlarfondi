<?php

namespace App\Models\Meeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class MeetingOffer extends Model
{
    use HasFactory, Translatable;

    protected array $translatable = ['offer', 'additional_information'];
    protected $fillable = ['user_id','offer','additional_information','image', 'verified'];
}
