<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->quizQuestionsData = $data['quizQuestionsData'] ?? [];
        unset($data['quizQuestionsData']);
        return $data;
    }

    protected function afterSave(): void
    {
        // Create or get the quiz
        $quiz = $this->record->quiz()->firstOrCreate([]);

        // Remove old questions
        $quiz->questions()->delete();

        // Add new ones
        foreach ($this->quizQuestionsData as $qData) {
            $quiz->questions()->create($qData);
        }
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
