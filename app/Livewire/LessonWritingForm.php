<?php

namespace App\Livewire;

use App\Models\LessonWriting;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LessonWritingForm extends Component
{
    public $lessonId;
    public $response = '';
    public $successMessage = '';

    public function submit()
    {
        $this->validate([
            'response' => 'required|string|max:5000',
        ]);

        LessonWriting::create([
            'user_id' => Auth::id(),
            'lesson_id' => $this->lessonId,
            'content' => $this->response,
        ]);

        $this->response = '';
        $this->successMessage = '✅ Your writing response has been saved!';
    }

    public function render()
    {
        return view('livewire.lesson-writing-form');
    }
}
