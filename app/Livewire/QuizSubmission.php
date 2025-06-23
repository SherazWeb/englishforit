<?php

namespace App\Livewire;

use App\Models\QuizAnswer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class QuizSubmission extends Component
{
    public $questionId;
    public $selectedOption = null;

    public function submit()
    {
        $question = \App\Models\QuizQuestion::findOrFail($this->questionId);

        QuizAnswer::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'quiz_question_id' => $this->questionId,
            ],
            [
                'selected_option' => $this->selectedOption,
                'is_correct' => $this->selectedOption === $correctKey = $question->correct_index,
            ]
        );

        $this->dispatch('answer-saved');
    }

    public function render()
    {
        return view('livewire.quiz-submission');
    }
}
