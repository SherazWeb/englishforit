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
                @foreach ($contents->quiz->questions as $question)
                    <livewire:quiz-submission :question-id="$question->id" :key="$question->id" />
                @endforeach
            @endif

            @if (!empty($contents))
                @livewire('lesson-writing-form', ['lessonId' => $contents->id, 'prompt' => $contents->writing_prompt])
            @endif
        </x-main-content>

    </div>

    <script>
        function moduleToggle(moduleId) {
            return {
                open: false,
                toggleModule(id) {
                    this.open = !this.open;
                    this.$root.activeModule = this.$root.activeModule === id ? null : id;
                    if (!this.open) {
                        this.$root.activeSubTopic = null;
                    }
                },
                activateLesson(lessonId) {
                    this.$root.activeSubTopic = lessonId;
                    this.$root.mobileSidebarOpen = false;
                }
            }
        }
    </script>

</x-layouts.app>
