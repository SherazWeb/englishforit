<?php

namespace App\Livewire;

use App\Models\QuizAnswer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class QuizSubmission extends Component
{
    public $questionId;
    public $selectedOption = null;
    protected $listeners = ['answer-saved' => 'handleAnswerSaved'];

    public function handleAnswerSaved()
    {
        // No need to modify this if you're just using the event
    }

    public function submit()
    {
        $question = \App\Models\QuizQuestion::findOrFail($this->questionId);
        $isCorrect = $this->selectedOption == $question->correct_index;

        QuizAnswer::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'quiz_question_id' => $this->questionId,
            ],
            [
                'selected_option' => $this->selectedOption,
                'is_correct' => $isCorrect,
            ]
        );

        $this->dispatch('answer-saved', correct: $isCorrect);
        return $isCorrect;
    }

    public function render()
    {
        return view('livewire.quiz-submission');
    }
}
