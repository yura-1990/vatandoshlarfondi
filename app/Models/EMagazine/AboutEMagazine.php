<?php

namespace App\Models\EMagazine;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TCG\Voyager\Traits\Translatable;

class AboutEMagazine extends Model
{
    use HasFactory, Translatable;
    protected $table = 'about_e_magazines';
    protected array $translatable = ['short_title', 'title'];

    public function eMagazine(): BelongsTo
    {
        return $this->belongsTo(EMagazine::class);
    }
}
