<?php

namespace App\Models\Userdata;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserEducation extends Model
{
    protected $table = 'user_educations';
    protected $fillable = [
        'user_id',
        'institution',
        'compatriot_expert_id',
        'level',
        'faculty',
        'specialization_id',
        'type'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function compatriotExpert(): BelongsTo
    {
        return $this->belongsTo(CompatriotExpert::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }
}
