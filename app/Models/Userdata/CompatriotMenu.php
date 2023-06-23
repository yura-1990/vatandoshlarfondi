<?php

namespace App\Models\Userdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class CompatriotMenu extends Model
{
    use HasFactory, Translatable;

    protected $table = 'compatriot_menus';
    protected array $translatable = ['name_uz'];
    protected $guarded = ['id'];
}
