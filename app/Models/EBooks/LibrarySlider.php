<?php

namespace App\Models\EBooks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class LibrarySlider extends Model
{
    use HasFactory, Translatable;

    protected array $translatable = ['title', 'text'];
}
