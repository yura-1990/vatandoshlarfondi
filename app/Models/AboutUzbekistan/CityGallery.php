<?php

namespace App\Models\AboutUzbekistan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TCG\Voyager\Traits\Translatable;

class CityGallery extends Model
{
    use HasFactory, Translatable;
    protected $table = 'city_galleries';
    protected array $translatable = ['title'];
    protected $fillable = ['city_id','image','title','download','share'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
