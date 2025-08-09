<?php

namespace App\Livewire;

use App\Models\QuizAnswer;
use App\Models\QuizQuestion as QQ;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class QuizQuestion extends Component
{
    public $questionId;
    public $selectedOption = null;
    public $isSubmitted = false;
    public $isCorrect = false;

    public function submit()
    {
        $question = QQ::findOrFail($this->questionId);
        $this->isCorrect = $this->selectedOption == $question->correct_index;

        QuizAnswer::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'quiz_question_id' => $this->questionId,
            ],
            [
                'selected_option' => $this->selectedOption,
                'is_correct' => $this->isCorrect,
            ]
        );

        $this->isSubmitted = true;
        $this->dispatch('answer-submitted');
    }

    public function render()
    {
        $question = QQ::findOrFail($this->questionId);
        
        return view('livewire.quiz-question', [
            'question' => $question,
            'options' => $question->options ?? [],
            'correctKey' => $question->correct_index,
            'explanation' => $question->explanation,
        ]);
    }
}