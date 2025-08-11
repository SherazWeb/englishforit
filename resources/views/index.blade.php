<x-layouts.app>

    <x-subheader />

    <div class="flex">
        <x-sidebar :modules="$modules" />

        <x-main-content>
            @if (!empty($contents))
                <x-lesson-listening :title="$contents->title" :audio-path="$contents->listening_audio_path" :transcript="$contents->listening_transcript" />

                <x-lesson-reading :content="$contents->reading_content" :vocabulary="$contents->reading_vocabulary" />
            @endif

            @if (!empty($contents->quiz) && $contents->quiz->questions->count())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden relative">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Quiz</h3>

                        @auth
                            <div x-data="{
                                totalQuestions: {{ $contents->quiz->questions->count() }},
                                answeredCount: 0,
                                incrementAnswered() {
                                    this.answeredCount++;
                                }
                            }">
                                <!-- Authenticated user sees normal quiz -->
                                <div class="flex justify-between items-center mt-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        Test your knowledge with this quiz
                                    </p>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <span x-text="answeredCount"></span> / <span x-text="totalQuestions"></span> answered
                                    </div>
                                </div>

                                <div class="space-y-6 mt-6">
                                    @foreach ($contents->quiz->questions as $question)
                                        <livewire:quiz-question :question-id="$question->id" :key="$question->id" />
                                    @endforeach
                                </div>

                                <div x-show="answeredCount === totalQuestions" x-transition
                                    class="mt-6 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg text-center">
                                    <p class="text-green-600 dark:text-green-400 font-semibold">
                                        🎉 Quiz Completed! Well done!
                                    </p>
                                </div>
                            </div>
                        @else
                            <!-- For guests: blurred preview with overlay -->
                            <div class="relative">
                                <!-- Blurred quiz preview -->
                                <div class="select-none pointer-events-none">
                                    <div class="flex justify-between items-center mt-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            Test your knowledge with this quiz
                                        </p>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            0 / {{ $contents->quiz->questions->count() }} answered
                                        </div>
                                    </div>

                                    <div class="space-y-6 mt-6">
                                        @foreach ($contents->quiz->questions->take(1) as $question)
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
                                                {{ $contents->quiz->questions->count() - 1 }} more questions...
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

</x-layouts.app>
