<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use TCG\Voyager\Models\Post;
use TCG\Voyager\Traits\Translatable;

class PostTag extends Model
{
    use HasFactory, Translatable;
    protected array $translatable = ['name'];
    protected $fillable = ['name'];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'posts_tags');
    }
}
