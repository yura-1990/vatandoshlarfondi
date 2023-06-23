<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class National extends Model
{
    use HasFactory;

    protected $table = 'public.nationals';
    protected $fillable = ['name'];
}
