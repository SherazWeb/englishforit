@props(['loader' => 'login'])

<button type="submit"
    {{ $attributes->merge(['class' => 'w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center justify-center gap-2']) }}
    wire:loading.attr="disabled"
    wire:target="{{ $loader }}">

    <span>{{ $slot }}</span>

    <svg wire:loading wire:target="{{ $loader }}"
        class="animate-spin h-5 w-5 text-white"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10"
            stroke="currentColor" stroke-width="4" />
        <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8v8H4z" />
    </svg>
</button>
