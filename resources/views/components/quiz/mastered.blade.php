<div class="mt-6 p-6 bg-green-50 dark:bg-green-900/20 rounded-2xl shadow text-center">
    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
        <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
    <h4 class="text-lg font-medium text-green-800 dark:text-green-300 mb-2">Quiz Mastered!</h4>
    <p class="text-green-600 dark:text-green-400">
        You've already mastered this quiz with a perfect score of {{ $latestAttempt->score }}/{{ $questions->count() }}.
    </p>
    <p class="text-sm text-green-500 dark:text-green-400 mt-2">
        Attempted on: {{ $latestAttempt->created_at->format('M j, Y') }}
    </p>
</div>