<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class QuizQuestion extends Model
{
    use Translatable;
    use HasFactory;

    protected $translatable = ['question'];

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class)->select('id', 'quiz_question_id', 'answer', 'image', 'order')->orderBy('order');
    }

}
