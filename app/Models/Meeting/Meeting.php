<?php

namespace App\Models\Meeting;

use App\Models\Public\Location;
use App\Models\PublicAssociation\CommunityAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Meeting extends Model
{
    use Translatable;

    use HasFactory;

    protected $translatable = ['title', 'description',];

    protected $fillable = [
        'title',
        'description',
        'type',
        'start_date',
        'url',
        'image',
        'video',
        'status',
    ];

    public function speakers()
    {
        return $this->belongsToMany(MeetingSpeaker::class, MeetingsSpeaker::class);
    }
}
