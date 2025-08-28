<x-layouts.app>

    <x-subheader />

    <div class="flex">
        <x-sidebar :modules="$modules" />

        <x-main-content>
            @if (!empty($contents))
                <x-lesson-listening :title="$contents->title" :audio-path="$contents->listening_audio_path" :transcript="$contents->listening_transcript" />

                <x-lesson-reading :content="$contents->reading_content" :vocabulary="$contents->reading_vocabulary" />
            @endif

            @if ($questions->count())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden relative">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Quiz</h3>

                        @auth
                            <!-- Check if user has already mastered this quiz -->
                            @if ($latestAttempt && $latestAttempt->status === 'mastered')
                                <div class="mt-6 p-6 bg-green-50 dark:bg-green-900/20 rounded-2xl shadow text-center">
                                    <div
                                        class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
                                        <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-green-800 dark:text-green-300 mb-2">Quiz Mastered!
                                    </h4>
                                    <p class="text-green-600 dark:text-green-400">
                                        You've already mastered this quiz with a perfect score of
                                        {{ $latestAttempt->score }}/{{ $questions->count() }}.
                                    </p>
                                    <p class="text-sm text-green-500 dark:text-green-400 mt-2">
                                        Attempted on: {{ $latestAttempt->created_at->format('M j, Y') }}
                                    </p>
                                </div>

                                <!-- Check if user has already used their one retry -->
                            @elseif($latestAttempt && $latestAttempt->attempt_number >= 2)
                                <div class="mt-6 p-6 bg-blue-50 dark:bg-blue-900/20 rounded-2xl shadow text-center">
                                    <div
                                        class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900/30 mb-4">
                                        <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-blue-800 dark:text-blue-300 mb-2">Maximum Attempts
                                        Reached</h4>
                                    <p class="text-blue-600 dark:text-blue-400">
                                        Your best score: {{ $latestAttempt->score }}/{{ $questions->count() }}
                                    </p>
                                    <p class="text-sm text-blue-500 dark:text-blue-400 mt-2">
                                        You've used both your initial attempt and one retry.
                                    </p>
                                </div>

                                <!-- User can take/retake the quiz -->
                            @else
                                <div x-data="{
                                    totalQuestions: {{ $questions->count() }},
                                    answeredCount: 0,
                                    correctCount: 0,
                                    incorrectCount: 0,
                                    currentAttempt: {{ $latestAttempt ? $latestAttempt->attempt_number + 1 : 1 }},
                                    maxAttempts: 2,
                                    incrementAnswered(isCorrect) {
                                        this.answeredCount++;
                                        if (isCorrect) {
                                            this.correctCount++;
                                        } else {
                                            this.incorrectCount++;
                                        };
                                
                                        if (this.answeredCount === this.totalQuestions) {
                                            Livewire.dispatch('quizCompleted',
                                                [
                                                    this.correctCount,
                                                    this.totalQuestions,
                                                    '{{ $contents->slug }}',
                                                    this.currentAttempt
                                                ]);
                                        }
                                    }
                                }"
                                    @answer-submitted.window="incrementAnswered($event.detail.isCorrect)">

                                    <!-- Attempt indicator -->
                                    <div class="flex justify-between items-center mt-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            Test your knowledge with this quiz
                                        </p>
                                        <div class="flex items-center space-x-4">
                                            <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full">
                                                Attempt: <span x-text="currentAttempt"></span>/<span
                                                    x-text="maxAttempts"></span>
                                            </span>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                <span x-text="answeredCount"></span> /
                                                <span x-text="totalQuestions"></span> answered
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Previous attempt info if exists -->
                                    @if ($latestAttempt)
                                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                Previous attempt: {{ $latestAttempt->score }}/{{ $questions->count() }}
                                                ({{ ucfirst($latestAttempt->status) }})
                                            </p>
                                        </div>
                                    @endif

                                    <div class="space-y-6 mt-6">
                                        @foreach ($questions as $question)
                                            <livewire:quiz-question :question-id="$question->id" :question-data="$question" :key="$question->id" />
                                        @endforeach
                                    </div>

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
                                                🔄 Retry Quiz (Attempt <span x-text="currentAttempt + 1"></span> of <span
                                                    x-text="maxAttempts"></span>)
                                            </button>
                                        </template>

                                        <template x-if="correctCount < 7 && currentAttempt >= maxAttempts">
                                            <p class="text-red-500 dark:text-red-400 font-medium">
                                                You've used all your attempts. Your best score was <span
                                                    x-text="correctCount"></span>/<span x-text="totalQuestions"></span>.
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
                                </div>
                            @endif
                        @else
                            <!-- For guests: blurred preview with overlay (unchanged) -->
                            <div class="relative">
                                <!-- Blurred quiz preview -->
                                <div class="select-none pointer-events-none">
                                    <div class="flex justify-between items-center mt-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            Test your knowledge with this quiz
                                        </p>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            0 / {{ $questions->count() }} answered
                                        </div>
                                    </div>

                                    <div class="space-y-6 mt-6">
                                        @foreach ($questions->take(1) as $question)
                                            <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                <h4 class="font-medium text-gray-800 dark:text-white mb-3">
                                                    {{ \Illuminate\Support\Str::limit($question->question, 50) }}
                                                </h4>
                                                <div class="space-y-2">
                                                    @foreach ($question->options as $option)
                                                        <div
                                                            class="flex items-center ps-4 border border-gray-200 dark:border-gray-700 rounded">
                                                            <input type="radio" class="w-4 h-4" disabled>
                                                            <label class="w-full py-2 ms-2 text-sm text-gray-500">
                                                                {{ \Illuminate\Support\Str::limit($option, 30) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="text-center text-gray-500 italic">
                                            {{ $questions->count() - 1 }} more questions...
                                        </div>
                                    </div>
                                </div>

                                <!-- Overlay sign-in message -->
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-white/70 dark:bg-gray-800/70 backdrop-blur-[1px]">
                                    <div class="max-w-md p-6 text-center">
                                        <div
                                            class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900/30 mb-4">
                                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Sign in to unlock
                                            this quiz</h4>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                                            Log in to test your knowledge and track your progress.
                                        </p>
                                        <div class="flex justify-center gap-3">
                                            <a @click="$dispatch('open-login-modal')"
                                                class="cursor-pointer inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Sign In
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            @endif



            @if (!empty($contents))
                @livewire('lesson-writing-form', ['lessonId' => $contents->id, 'prompt' => $contents->writing_prompt])
            @endif
        </x-main-content>

    </div>
    <livewire:quiz-attempts />
</x-layouts.app>
