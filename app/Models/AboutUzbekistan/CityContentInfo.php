<?php

namespace App\Models\AboutUzbekistan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpseclib3\Exception\FileNotFoundException;
use TCG\Voyager\Traits\Translatable;

class CityContentInfo extends Model
{
    use HasFactory, Translatable;
    protected $table = 'city_content_infos';
    protected array $translatable = ['title', 'content'];
    protected $fillable = ['city_id','sightseeing_place_id','title','content'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
