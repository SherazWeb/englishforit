<div>
    @if ($currentQuestionId)
        <livewire:quiz-submission :question-id="$currentQuestionId" wire:key="'q-'.$currentQuestionId" />

        <div class="mt-4">
            @if (!$isLast)
                <button wire:click="nextQuestion" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Next Question →
                </button>
            @else
                <div class="text-green-600 font-semibold mt-2">
                    🎉 Quiz Completed!
                </div>
            @endif
        </div>
    @else
        <div>No questions found for this quiz.</div>
    @endif
</div>
