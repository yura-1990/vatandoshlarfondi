<?php

namespace App\Models\Userdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;
    protected $table = 'specializations';
    protected $fillable = ['title'];
}
