<?php

namespace App\Models\Meeting;

use App\Models\Public\Location;
use App\Models\PublicAssociation\CommunityAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'meeting_id'];

}
