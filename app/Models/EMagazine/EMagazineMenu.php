<?php

namespace App\Models\EMagazine;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class EMagazineMenu extends Model
{
    use HasFactory, Translatable;

    protected $table = 'e_magazine_menus';
    protected array $translatable = ['title', 'text', 'name'];
}
