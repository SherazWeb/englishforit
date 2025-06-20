<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $casts = [
        'reading_vocabulary' => 'array',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

    public function quizQuestions()
{
    return $this->hasManyThrough(
        QuizQuestion::class,
        Quiz::class,
        'lesson_id', // Foreign key on quizzes table
        'quiz_id',   // Foreign key on quiz_questions table
        'id',        // Local key on lessons table
        'id'         // Local key on quizzes table
    );
}
}
