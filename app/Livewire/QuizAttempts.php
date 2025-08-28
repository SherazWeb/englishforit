<?php

namespace App\Livewire;

use App\Models\Lesson;
use App\Models\QuizAttempt;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class QuizAttempts extends Component
{

    protected $listeners = ['quizCompleted' => 'handleQuizCompleted'];

    public function handleQuizCompleted($correct, $total, $lessonSlug)
    {
        $userId = Auth::id();

        $lesson = \App\Models\Lesson::where('slug', $lessonSlug)->first();

        if (!$lesson) {
            logger()->error("Lesson not found for slug: {$lessonSlug}");
            return;
        }

        $attemptNumber = QuizAttempt::where('user_id', $userId)
            ->where('lesson_id', $lesson->id)
            ->max('attempt_number') ?? 0;

        $status = match ($correct) {
            8       => 'mastered',
            7       => 'Almost Perfect',
            default => 'completed',
        };

        QuizAttempt::create([
            'user_id' => $userId,
            'lesson_id' => $lesson->id,
            'score' => $correct,
            'status' => $status,
            'attempt_number' => $attemptNumber + 1,
        ]);
    }

    public function render()
    {
        return view('livewire.quiz-attempts');
    }
}
