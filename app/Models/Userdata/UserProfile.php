<?php

namespace App\Models\Userdata;

use App\Enums\FamilyStatusEnum;
use App\Enums\GenderEnum;
use App\Models\Public\Location;
use App\Models\Public\LocationCity;
use App\Models\Public\National;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserProfile extends Model
{
    protected $table = 'user_profile';
    protected $fillable = [
        'id',
        'user_id',
        'first_name',
        'second_name',
        'last_name',
        'national_address',
        'international_location_id',
        'international_address_id',
        'national_id',
        'birth_date',
        'gender',
        'avatar_url',
        'passport_file',
        'phone_number',
        'academic_degree',
        'scientific_title',
        'job_position',
        'work_experience',
        'additional_info',
        'achievements',
        'family_status',
        'hobbies',
        'interests',
        'opinions_about_uzbekistan',
        'suggestions_and_recommendations',
        'timezone',
        'language'
    ];

    /**
     * Get the user's data.
     */
    protected function userId(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value != null ? User::query()->find($value) : null,
        );
    }

    /**
     * Get the user's international location.
     */
    protected function internationalLocationId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != null ? Location::query()->find($value) : null,
        );
    }

    /**
     * Get the user's international location.
     */
    protected function internationalAddressId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != null ? Location::query()->find($value) : null,
        );
    }

    /**
     * Get the user's national language.
     */
    protected function nationalId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != null ? National::query()->find($value) : null,
        );
    }

    public static function timezones()
    {
        $timezones = [
            'GMT-12:00',
            'GMT-11:00',
            'GMT-10:00',
            'GMT-09:00',
            'GMT-08:00',
            'GMT-07:00',
            'GMT-06:00',
            'GMT-05:00',
            'GMT-04:30',
            'GMT-04:00',
            'GMT-03:30',
            'GMT-03:00',
            'GMT-02:00',
            'GMT-01:00',
            'GMT',
            'GMT+01:00',
            'GMT+02:00',
            'GMT+03:00',
            'GMT+03:30',
            'GMT+04:00',
            'GMT+04:30',
            'GMT+05:00',
            'GMT+05:30',
            'GMT+05:45',
            'GMT+06:00',
            'GMT+06:30',
            'GMT+07:00',
            'GMT+08:00',
            'GMT+08:45',
            'GMT+09:00',
            'GMT+09:30',
            'GMT+10:00',
            'GMT+10:30',
            'GMT+11:00',
            'GMT+11:30',
            'GMT+12:00',
            'GMT+12:45',
            'GMT+13:00',
            'GMT+14:00',
        ];
    }

    public function compatriotExpert(): HasOne
    {
        return $this->hasOne(CompatriotExpert::class);
    }

    public function locationCity(): BelongsTo
    {
        return $this->belongsTo(LocationCity::class, 'international_address_id');
    }

}
