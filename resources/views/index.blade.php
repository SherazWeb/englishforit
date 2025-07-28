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
                <div x-data="{
                    currentQuestion: 0,
                    totalQuestions: {{ $contents->quiz->questions->count() }},
                    score: 0,
                    nextQuestion() {
                        if (this.currentQuestion < this.totalQuestions - 1) {
                            this.currentQuestion++;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    }
                }">
                    <!-- Progress bar -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm mb-1">
                            <span>Question <span x-text="currentQuestion + 1"></span>/<span
                                    x-text="totalQuestions"></span></span>
                            <span x-text="score" class="font-bold"></span>/<span x-text="totalQuestions"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-indigo-600 h-2.5 rounded-full"
                                :style="`width: ${((currentQuestion + 1)/totalQuestions)*100}%`"></div>
                        </div>
                    </div>

                    <!-- Questions container -->
                    <div class="space-y-6">
                        @foreach ($contents->quiz->questions as $index => $question)
                            <div x-show="currentQuestion === {{ $index }}" x-transition>
                                <livewire:quiz-submission :question-id="$question->id" :key="$question->id"
                                    @answer-saved="(correct) => { if(correct) score++; nextQuestion(); }" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Results screen -->
                <div x-show="currentQuestion >= totalQuestions" x-transition
                    class="mt-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow text-center">
                    <h3 class="text-2xl font-bold mb-4">Quiz Completed!</h3>
                    <p class="text-lg mb-2">Your score: <span x-text="score" class="font-bold"></span>/<span
                            x-text="totalQuestions"></span></p>

                    <div x-show="score === totalQuestions" class="mt-4 p-3 bg-green-100 dark:bg-green-900 rounded">
                        Perfect! You've mastered this IT English concept!
                    </div>
                    <div x-show="score/totalQuestions >= 0.7 && score < totalQuestions"
                        class="mt-4 p-3 bg-blue-100 dark:bg-blue-900 rounded">
                        Good job! You're almost there - review the explanations to improve.
                    </div>
                    <div x-show="score/totalQuestions < 0.7" class="mt-4 p-3 bg-yellow-100 dark:bg-yellow-900 rounded">
                        Keep practicing! Consider reviewing the lesson material before trying again.
                    </div>

                    <button @click="currentQuestion = 0; score = 0;"
                        class="mt-6 px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        Retake Quiz
                    </button>
                </div>
            @endif


            @if (!empty($contents))
                @livewire('lesson-writing-form', ['lessonId' => $contents->id, 'prompt' => $contents->writing_prompt])
            @endif
        </x-main-content>

    </div>

</x-layouts.app>
