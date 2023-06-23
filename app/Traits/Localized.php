<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait Localized
{
    public function scopeLocalized($query)
    {
        return $query->where('locale', App::getLocale());
    }
}
