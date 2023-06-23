<?php

namespace App\Models\PublicAssociation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityAttachment extends Model
{
    use HasFactory;

    protected $table = "community_attachments";
    protected $fillable = ['type', 'path', 'order', 'community_id', 'community_news_id', 'community_event_id'];
}
