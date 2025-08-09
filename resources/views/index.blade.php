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
                    totalQuestions: {{ $contents->quiz->questions->count() }},
                    answeredCount: 0,
                    incrementAnswered() {
                        this.answeredCount++;
                    }
                }">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Quiz</h3>
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                <span x-text="answeredCount"></span> / <span x-text="totalQuestions"></span> answered
                            </div>
                        </div>

                        <div class="space-y-6">
                            @foreach ($contents->quiz->questions as $question)
                                <livewire:quiz-question :question-id="$question->id" :key="$question->id"
                                     />
                            @endforeach
                        </div>

                        <div x-show="answeredCount === totalQuestions" x-transition
                            class="mt-6 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg text-center">
                            <p class="text-green-600 dark:text-green-400 font-semibold">
                                🎉 Quiz Completed! Well done!
                            </p>
                        </div>
                    </div>
                </div>
            @endif



            @if (!empty($contents))
                @livewire('lesson-writing-form', ['lessonId' => $contents->id, 'prompt' => $contents->writing_prompt])
            @endif
        </x-main-content>

    </div>

</x-layouts.app>
