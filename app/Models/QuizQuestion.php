<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
    ];

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'quiz_question_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}

