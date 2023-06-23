<?php

namespace App\Models\NewsOrEvents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TCG\Voyager\Traits\Translatable;

class NewsOrEvent extends Model
{
    use HasFactory, Translatable;
    protected $table = 'news_or_events';

    protected array $translatable = ['tags', 'text', 'title'];
    protected $fillable = ['image', 'images', 'data', 'status', 'tags', 'text', 'title', 'viewers'];

    protected $casts = [ 'tags' => 'array', ];

    public function newsOrEventType(): BelongsTo
    {
        return $this->belongsTo(NewsOrEventType::class);
    }
}
