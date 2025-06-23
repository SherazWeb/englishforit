<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    protected $fillable = ['user_id', 'quiz_question_id', 'selected_option', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
