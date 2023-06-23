<?php

namespace App\Models\AboutUzbekistan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TCG\Voyager\Traits\Translatable;

class AboutUzbekistanPageMenu extends Model
{
    use HasFactory, Translatable;

    protected $table = 'about_uzbekistan_page_menus';
    protected $translatable = ['name'];
    protected $fillable=['name', 'image'];

    public function pageMenuContents(): HasMany
    {
        return $this->hasMany(PageMenuContent::class);
    }
}
