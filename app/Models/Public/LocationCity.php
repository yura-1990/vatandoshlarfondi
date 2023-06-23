<?php

namespace App\Models\Public;

use App\Models\Userdata\UserProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LocationCity extends Model
{
    use HasFactory;

    protected $table = 'location_cities';

    protected $fillable = [
        'location_id',
        'city'
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function userProfile(): HasMany
    {
        return $this->hasMany(UserProfile::class, 'international_address_id');
    }
}
