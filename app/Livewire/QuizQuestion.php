<?php

namespace App\Livewire;

use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class QuizQuestion extends Component
{
    public $questionId;
    public $questionData;
    public $selectedOption = null;
    public $isSubmitted = false;
    public $isCorrect = false;
    public $attemptId;
    public $counter = 0;

    public function saveAnswer($selected, $isCorrect)
    {
        QuizAnswer::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'quiz_question_id' => $this->questionId,
                'quiz_attempt_id' => $this->attemptId, 
            ],
            [
                'selected_option' => $selected,
                'is_correct' => $isCorrect,
            ]
        );

        // Notify Alpine/Livewire about the answer
        $this->dispatch('answer-submitted', isCorrect: $isCorrect);
    }




    public function render()
    {
        return view('livewire.quiz-question', [
            'question'    => $this->questionData,
            'options'     => $this->questionData->options ?? [],
            'correctKey'  => $this->questionData->correct_index,
            'explanation' => $this->questionData->explanation,
        ]);
    }
}
