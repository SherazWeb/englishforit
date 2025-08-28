<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Make sure we're using 'quizQuestions' (not 'quizQuestionsData')
        $quizQuestions = $data['quizQuestions'] ?? [];
        unset($data['quizQuestions']);

        // Store in session temporarily so we can access it after create
        session()->put('lesson_quiz_questions', $quizQuestions);

        return $data;
    }

    protected function afterCreate(): void
    {
        $quizQuestions = session()->pull('lesson_quiz_questions', []);

        $lesson = $this->record;

        // Create Quiz
        $quiz = $lesson->quiz()->create();

        // Create Questions
        foreach ($quizQuestions as $question) {
            $quiz->questions()->create($question);
        }
    }
}