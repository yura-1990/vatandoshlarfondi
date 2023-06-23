<?php

namespace App\Models\PublicAssociation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityNew extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'description', 'community_id'];

    protected $table = "community_news";
}
