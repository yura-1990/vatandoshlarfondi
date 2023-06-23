<?php

namespace App\Models\Userdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVolunteerOrExpertActivity extends Model
{
    use HasFactory;
    protected $table='user_volunteer_or_compatriot_activities';

    protected $fillable=[
        'user_id',
        'title',
        'description',
        'images',
        'compatriot_expert_id',
        'verified',
        'type',
        'viewers'
    ];

    public function compatriotExpert(): BelongsTo
    {
        return $this->belongsTo(CompatriotExpert::class, 'compatriot_expert_id');
    }


}
