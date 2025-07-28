<?php

namespace App\Livewire;

use App\Models\Quiz;
use Livewire\Component;

class QuizRunner extends Component
{
    public $quizId;
    public $questionIndex = 0;
    public $questionIds = [];

    public function mount($quizId)
    {
        $this->quizId = $quizId;
        $this->questionIds = Quiz::findOrFail($quizId)->questions->pluck('id')->toArray();
    }

    public function nextQuestion()
    {
        if ($this->questionIndex < count($this->questionIds) - 1) {
            $this->questionIndex++;
        }
    }

    public function render()
    {
        return view('livewire.quiz-runner', [
            'currentQuestionId' => $this->questionIds[$this->questionIndex] ?? null,
            'isLast' => $this->questionIndex === count($this->questionIds) - 1,
        ]);
    }
}
