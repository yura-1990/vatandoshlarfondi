<?php

namespace App\Models\NewsOrEvents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TCG\Voyager\Traits\Translatable;

class NewsOrEventType extends Model
{
    use HasFactory, Translatable;
    protected $table = 'news_or_event_types';

    protected array $translatable = ['name'];

    public function newsOrEvents(): HasMany
    {
        return $this->hasMany(NewsOrEvent::class);
    }
}
