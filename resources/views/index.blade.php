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
                            @if ($latestAttempt && $latestAttempt->status === 'mastered')
                                <x-quiz.mastered :latestAttempt="$latestAttempt" :questions="$questions" />
                            @elseif($latestAttempt && $latestAttempt->attempt_number >= 2 && $latestAttempt->status != 'in_progress')
                                <x-quiz.max-attempts :latestAttempt="$latestAttempt" :questions="$questions" :highestScore="$max_score" />
                            @else
                                <x-quiz.attempt :questions="$questions" :contents="$contents" :latestAttempt="$latestAttempt" :highestScore="$max_score" />
                            @endif
                        @else
                            <x-quiz.guest-preview :questions="$questions" />
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
