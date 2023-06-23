<?php

namespace App\Models\EBooks;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;


class ELibrary extends Model
{
    use Translatable;
    protected $table="e_libraries";
    protected array $translatable = ['title', 'text','type','format'];
    protected $fillable = [
        'title',
        'stars',
        'viewers',
        'author',
        'language',
        'text',
        'type',
        'format',
        'publication',
        'ages',
        'stir',
        'pages',
        'thumbnail',
        'image',
    ];


    public static function scopeSearch($query, $columns, $search)
    {
        foreach($columns as $column){
             $query->orWhere($column, 'LIKE', '%' . $search . '%');
        }

        return $query;
    }
}
