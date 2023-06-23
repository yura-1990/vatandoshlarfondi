<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Quiz extends Model
{
    use Translatable;
    use HasFactory;

    protected $translatable = ['title', 'description',];

    protected $table = "quizzes";

    public function participants()
    {
        return $this->hasMany(QuizParticipant::class)->where('position', '>',0)->with(['user']);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->with('answers')->orderBy('order');
    }

}
