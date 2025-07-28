@php
    $question = \App\Models\QuizQuestion::find($questionId);
    $options = $question->options;
    $correctKey = $question->correct_index;
@endphp

<div class="p-4 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900"
    x-data="{
        selected: @entangle('selectedOption'),
        submitted: false,
        correctIndex: '{{ $correctKey }}',
        explanation: @js($question->explanation),
        checkAnswer() {
            $wire.submit().then((isCorrect) => {
                this.submitted = true;
                // This will trigger the parent component's score update
            });
        }
    }">

    <h3 class="font-semibold text-lg text-gray-800 dark:text-white">
        {!! $question->question !!}
    </h3>

    <div class="mt-3 space-y-2">
        @foreach ($options as $key => $option)
            <label class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                <input type="radio" x-model="selected" value="{{ $key }}"
                    class="form-radio text-indigo-600 dark:bg-gray-800">
                <span>{{ $option }}</span>
            </label>
        @endforeach
    </div>

    <button @click="checkAnswer" :disabled="!selected || submitted"
        class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition disabled:opacity-50">
        Submit Answer
    </button>

    <template x-if="submitted">
        <div class="mt-3">
            <template x-if="selected === correctIndex">
                <div class="text-green-600 dark:text-green-400 font-semibold">
                    ✅ Correct! <span class="block text-sm mt-1" x-text="explanation"></span>
                </div>
            </template>
            <template x-if="selected !== correctIndex">
                <div class="text-red-600 dark:text-red-400 font-semibold">
                    ❌ Incorrect. <span class="block text-sm mt-1" x-text="explanation"></span>
                </div>
            </template>
        </div>
    </template>
</div>
