<?php

namespace App\Livewire;

use App\Models\Lesson;
use App\Models\QuizAttempt;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class QuizAttempts extends Component
{

    protected $listeners = ['quizCompleted' => 'handleQuizCompleted'];

    public function handleQuizCompleted($correct, $total, $lessonSlug, $currentAttemptId)
    {
        $userId = Auth::id();

        $lesson = \App\Models\Lesson::where('slug', $lessonSlug)->first();

        if (!$lesson) {
            logger()->error("Lesson not found for slug: {$lessonSlug}");
            return;
        }

        $status = match (true) {
            $correct === 8 => 'mastered',
            $correct === 7 => 'almost_perfect',
            default        => 'completed',
        };

        // Find the existing attempt by ID
        $attempt = QuizAttempt::where('id', $currentAttemptId)
            ->where('user_id', $userId)
            ->where('lesson_id', $lesson->id)
            ->first();

        if ($attempt) {
            $attempt->update([
                'score'  => $correct,
                'status' => $status,
            ]);
        } else {
            logger()->warning("Attempt not found for ID: {$currentAttemptId}, user: {$userId}, lesson: {$lesson->id}");
        }
    }



    public function render()
    {
        return view('livewire.quiz-attempts');
    }
}
