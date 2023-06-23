<?php

namespace App\Models\PublicAssociation;

use App\Models\Public\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TCG\Voyager\Traits\Translatable;

class Community extends Model
{
    use Translatable;
    use HasFactory;

    protected $translatable = ['name', 'title', 'description', 'document', 'director', 'work',];

    protected $table = "communities";

    protected $fillable = ['name',
        'title',
        'description',
        'logo',
        'document',
        'director',
        'director_img',
        'work',
        'created_date',
        'members',
        'achievement',
        'region_id',
        'city_id',
        'phone',
        'email',
        'address',
        'site',
        'user_id',
        'status'
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'region_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'city_id', 'id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(CommunityAttachment::class);
    }

}
