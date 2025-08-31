<div x-show="answeredCount === totalQuestions" x-transition
    class="mt-6 p-6 bg-green-50 dark:bg-green-900/20 rounded-2xl shadow text-center space-y-3">
    <p class="text-green-600 dark:text-green-400 font-bold text-lg">
        🎉 Quiz Completed! Well done!
    </p>

    <!-- Correct and Incorrect Counts -->
    <p class="text-gray-800 dark:text-gray-200">
        ✅ Correct Answers: <span x-text="correctCount"></span>
    </p>
    <p class="text-gray-800 dark:text-gray-200">
        ❌ Incorrect Answers: <span x-text="incorrectCount"></span>
    </p>

    <!-- Show different options based on score and attempt number -->
    <template x-if="correctCount < 7 && currentAttempt < maxAttempts">
        <button @click="window.location.reload()"
            class="mt-4 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow transition">
            🔄 Retry Quiz (Attempt <span x-text="currentAttempt + 1"></span> of <span x-text="maxAttempts"></span>)
        </button>
    </template>

    <template x-if="correctCount < 7 && currentAttempt >= maxAttempts">
        <p class="text-red-500 dark:text-red-400 font-medium">
            You've used all your attempts. Your best score was <span x-text="maxScore"></span>/<span x-text="totalQuestions"></span>.
        </p>
    </template>

    <template x-if="correctCount === 7">
        <p class="text-blue-600 dark:text-blue-400 font-medium">
            🌟 Excellent Work! You scored 7/8.
        </p>
    </template>

    <template x-if="correctCount === 8">
        <p class="text-green-600 dark:text-green-400 font-medium">
            🏆 Mastered the Quiz! Perfect score!
        </p>
    </template>
</div>