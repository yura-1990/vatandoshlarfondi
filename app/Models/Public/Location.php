<?php

namespace App\Models\Public;

use App\Models\PublicAssociation\CommunityEvent;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TCG\Voyager\Models\Post;
use TCG\Voyager\Traits\Translatable;

class Location extends Model
{
    use Translatable;

    protected array $translatable = ['name', 'b_title', 'b_description'];

    public function userInternationalProfiles(): HasMany
    {
        return $this->hasMany(UserProfile::class, 'international_location_id');
    }

    public function userInternationalAddressProfiles(): HasMany
    {
        return $this->hasMany(UserProfile::class, 'international_address_id');
    }

    public function locationCities(): HasMany
    {
        return $this->hasMany(LocationCity::class);
    }
    public function compatriotExperts(): HasMany
    {
        return $this->hasMany(CompatriotExpert::class);
    }
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'location_id');
    }

    public function communityEvents(): HasMany
    {
        return $this->hasMany(CommunityEvent::class);
    }
}
