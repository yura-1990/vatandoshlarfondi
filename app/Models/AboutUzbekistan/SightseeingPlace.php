<?php

namespace App\Models\AboutUzbekistan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TCG\Voyager\Traits\Translatable;

class SightseeingPlace extends Model
{
    use HasFactory, Translatable;

    protected $table = 'sightseeing_places';
    protected array $translatable = ['title', 'content_title', 'text'];
    protected $fillable = ['city_id', 'image', 'thumbnail', 'title', 'content_title', 'text'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
