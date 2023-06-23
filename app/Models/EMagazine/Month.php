<?php

namespace App\Models\EMagazine;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TCG\Voyager\Traits\Translatable;

class Month extends Model
{
    use HasFactory, Translatable;

    protected $table = 'months';
    protected array $translatable = ['name'];

    public function eMagazines(): HasMany
    {
        return $this->hasMany(EMagazine::class);
    }
}
