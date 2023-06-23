<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizParticipantImage extends Model
{
    use HasFactory;

    protected $table = "quiz_participant_images";

    protected $fillable = ['quiz_participant_id', 'image'];

}
