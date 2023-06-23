<?php

namespace App\Models\AboutUzbekistan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TCG\Voyager\Traits\Translatable;

class City extends Model
{
    use HasFactory, Translatable;
    protected $table = 'cities';
    protected array $translatable = ['name'];
    protected $fillable = ['name'];

    public function sightseeingPlaces(): HasMany
    {
        return $this->hasMany(SightseeingPlace::class);
    }

    public function cityGalleries(): HasMany
    {
        return $this->hasMany(CityGallery::class);
    }

    public function cityVideos(): HasMany
    {
        return $this->hasMany(CityVideo::class);
    }

    public function city3Ds(): HasMany
    {
        return $this->hasMany(City3D::class);
    }

    public function cityContentInfos(): HasMany
    {
        return $this->hasMany(CityContentInfo::class);
    }

}
