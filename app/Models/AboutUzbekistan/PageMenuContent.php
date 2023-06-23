<?php

namespace App\Models\AboutUzbekistan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TCG\Voyager\Traits\Translatable;

class PageMenuContent extends Model
{
    use HasFactory, Translatable;
    protected $table = 'page_menu_contents';
    protected array $translatable = ['title', 'text'];
    protected $fillable = ['title', 'text', 'about_uzbekistan_page_menu_id'];

    public function aboutUzbekistanPageMenu(): BelongsTo
    {
        return $this->belongsTo(AboutUzbekistanPageMenu::class);
    }

}
