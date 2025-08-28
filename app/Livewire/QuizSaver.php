<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\QuizAnswer;
use Illuminate\Support\Facades\Auth;

class QuizSaver extends Component
{
    public function saveAllAnswers($answers)
    {
        foreach($answers as $questionId => $data) {
            QuizAnswer::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'quiz_question_id' => $questionId,
                ],
                [
                    'selected_option' => $data['selected'],
                    'is_correct' => $data['correct'],
                ]
            );
        }

        $this->dispatchBrowserEvent('quiz-submitted', ['message' => 'All answers saved!']);
    }

    public function render()
    {
        return view('livewire.quiz-saver'); // empty view
    }
}
