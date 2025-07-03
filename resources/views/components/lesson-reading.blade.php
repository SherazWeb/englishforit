<section class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-4 dark:text-white">📖 Reading</h2>

    <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
        {!! $content !!}
    </div>

    @if ($vocabulary)
        <div class="mt-4">
            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">Vocabulary</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach ($vocabulary as $item)
                    <div class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100 p-3 rounded-lg shadow-sm">
                        <strong class="text-gray-900 dark:text-white">{{ $item['term'] }}:</strong>
                        <span class="block mt-1">{{ $item['definition'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>
