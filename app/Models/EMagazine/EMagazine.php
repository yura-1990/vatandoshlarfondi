<?php

namespace App\Models\EMagazine;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TCG\Voyager\Traits\Translatable;

class EMagazine extends Model
{
    use HasFactory, Translatable;
    protected $table = 'e_magazines';
    protected array $translatable = ['title', 'short_content', 'text'];
    protected $fillable = ['title', 'short_content', 'text', 'thumbnail', 'month_id', 'start_data_edition', 'images', 'pages', 'viewers'];

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    public function aboutEMagazines(): HasMany
    {
        return $this->hasMany(AboutEMagazine::class);
    }
}
