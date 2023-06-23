<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class QuizAnswer extends Model
{
    use HasFactory;
    use Translatable;
    protected $translatable = ['answer'];

    protected $fillable = ['quiz_question_id', 'answer', 'image', 'order'];

}
