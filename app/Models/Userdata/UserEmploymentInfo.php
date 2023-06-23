<?php

namespace App\Models\Userdata;

use App\Models\Public\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEmploymentInfo extends Model
{
    protected $table = 'user_employment_infos';

    protected $fillable = [
        'user_id',
        'company',
        'city',
        'compatriot_expert_id',
        'position',
        'status',
        'start_date',
        'finish_date',
        'location_id',
        'specialization'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function compatriotExpert(): BelongsTo
    {
        return $this->belongsTo(CompatriotExpert::class);
    }
}
