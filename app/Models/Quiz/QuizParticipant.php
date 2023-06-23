<?php

namespace App\Models\Quiz;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizParticipant extends Model
{
    use HasFactory;

    protected $table = "quiz_participants";

    protected $fillable = ['user_id', 'quiz_id', 'description'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

}
