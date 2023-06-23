<?php

namespace App\Models\AboutUzbekistan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TCG\Voyager\Traits\Translatable;

class CityVideo extends Model
{
    use HasFactory, Translatable;
    protected $table = 'city_videos';
    protected array $translatable = ['title', 'content'];
    protected $fillable = ['city_id','title','content','video'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
