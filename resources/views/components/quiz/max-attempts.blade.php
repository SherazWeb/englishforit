<div class="mt-6 p-6 bg-blue-50 dark:bg-blue-900/20 rounded-2xl shadow text-center">
    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900/30 mb-4">
        <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
    <h4 class="text-lg font-medium text-blue-800 dark:text-blue-300 mb-2">Maximum Attempts Reached</h4>
    <p class="text-blue-600 dark:text-blue-400">
        Your best score: {{ $highestScore }}/{{ $questions->count() }}
    </p>
    <p class="text-sm text-blue-500 dark:text-blue-400 mt-2">
        You've used both your initial attempt and one retry.
    </p>
</div>