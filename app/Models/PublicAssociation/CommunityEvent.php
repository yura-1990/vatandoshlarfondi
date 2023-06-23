<?php

namespace App\Models\PublicAssociation;

use App\Models\Public\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TCG\Voyager\Traits\Translatable;

class CommunityEvent extends Model
{
    use Translatable;
    use HasFactory;
    protected array $translatable = ['title', 'content',];

    protected $table = "community_events";

    protected $fillable = ['id', 'title', 'description', 'content', 'date', 'video'];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

}
