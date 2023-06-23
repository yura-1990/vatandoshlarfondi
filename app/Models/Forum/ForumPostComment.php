<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPostComment extends Model
{
    use HasFactory;

    protected $table = "forum_post_comments";
}
