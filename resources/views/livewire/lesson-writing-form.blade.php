<div x-data="{ open: true }" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-4 dark:text-white">✍️ 4. Write It Yourself</h2>

    <p class="text-gray-700 dark:text-gray-300 mb-2">
        {{ $prompt ?? 'Based on the lesson, write your thoughts below.' }}
    </p>

    @if ($successMessage)
        <div class="mb-4 text-green-600 dark:text-green-400 font-semibold">
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <textarea wire:model.defer="response" rows="5"
            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 transition"
            placeholder="Example: Yesterday I completed the dashboard layout. Today I'll integrate Mixpanel tracking. No blockers right now."></textarea>

        @error('response')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror

        <button type="submit"
            class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            Submit
        </button>
    </form>
</div>
