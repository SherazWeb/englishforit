<div x-data="quizAttempt({{ $questions->count() }}, {{ $latestAttempt->id }}, {{ $latestAttempt->attempt_number }}, {{ $highestScore }}, '{{ $contents->slug }}')" @answer-submitted.window="incrementAnswered($event.detail.isCorrect)">

    <!-- Attempt indicator -->
    <div class="flex justify-between items-center mt-4">
        <p class="text-sm text-gray-600 dark:text-gray-300">
            Test your knowledge with this quiz
        </p>
        <div class="flex items-center space-x-4">
            <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full">
                Attempt <span x-text="currentAttempt"></span> of <span x-text="maxAttempts"></span>
            </span>
            <div class="text-sm text-gray-600 dark:text-gray-300">
                <span x-text="answeredCount"></span> / <span x-text="totalQuestions"></span> answered
            </div>
        </div>
    </div>

    <!-- Previous attempt info if exists -->
    {{-- @if ($latestAttempt)
        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Previous attempt: {{ $latestAttempt->score }}/{{ $questions->count() }}
                ({{ ucfirst($latestAttempt->status) }})
            </p>
        </div>
    @endif --}}

    <div class="space-y-6 mt-6">
        @foreach ($questions as $question)
            <livewire:quiz-question :question-id="$question->id" :question-data="$question" :attempt-id="$latestAttempt->id" :key="$question->id" />
        @endforeach
    </div>

    <x-quiz.completion-message />
</div>

<script>
    function quizAttempt(totalQuestions, currentAttemptId, attemptNumber, maxScore, contentSlug) {
        return {
            totalQuestions: totalQuestions,
            answeredCount: 0,
            correctCount: 0,
            incorrectCount: 0,
            currentAttemptId: currentAttemptId,
            currentAttempt: attemptNumber,
            maxAttempts: 2,
            maxScore: maxScore,
            incrementAnswered(isCorrect) {
                this.answeredCount++;
                if (isCorrect) {
                    this.correctCount++;
                } else {
                    this.incorrectCount++;
                };

                if (this.answeredCount === this.totalQuestions) {
                    Livewire.dispatch('quizCompleted', [
                        this.correctCount,
                        this.totalQuestions,
                        contentSlug,
                        this.currentAttemptId
                    ]);
                }
            }
        }
    }
</script>
