<section class="bg-white dark:bg-gray-800 rounded-lg shadow p-6" x-data="{ showText: false }">
    <h2 class="text-2xl font-bold mb-4 dark:text-white">🎧 {{ $title }}</h2>

    @if ($audioPath)
        <audio controls class="w-full mb-4">
            <source src="{{ asset($audioPath) }}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    @endif

    @if ($transcript)
        <button @click="showText = !showText"
                class="mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
            <span x-text="showText ? '🔼 Hide Conversation' : '🔽 Show Conversation'"></span>
        </button>
        <div x-show="showText" x-transition class="text-gray-700 dark:text-gray-300 space-y-2">
            {!! $transcript !!}
        </div>
    @endif
</section>
