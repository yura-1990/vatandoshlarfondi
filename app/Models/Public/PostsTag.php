<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCG\Voyager\Traits\Translatable;

class PostsTag extends Model
{
    use HasFactory;


    protected $fillable = ['post_id', 'post_tag_id'];
}
