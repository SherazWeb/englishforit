<aside
    class="w-64 bg-white dark:bg-gray-800 shadow-md fixed h-[calc(100vh-5rem)] z-10 transition-all duration-300 ease-in-out border-r border-gray-200 dark:border-gray-700"
    :class="mobileSidebarOpen ? 'left-0' : '-left-64 md:left-0'">
    <div class="overflow-y-auto h-full pb-20 px-4 py-2">
        <h3 class="font-bold text-lg mb-2 dark:text-white">Modules</h3>
        <div class="space-y-1">
            @foreach ($modules as $module)
                @php
                    // Check if this module is active based on URL
                    $isActiveModule = request()->is($module->slug) || request()->is($module->slug . '/*');
                @endphp

                <div x-data="{ open: {{ $isActiveModule ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full text-left px-2 py-2 bg-gray-100 dark:bg-gray-700 rounded flex justify-between items-center hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                        :class="open ? 'text-w3schools dark:text-w3schools-light font-semibold' :
                            'text-gray-800 dark:text-gray-200'">
                        <span>{{ $module->title }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform"
                            :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                        @foreach ($module->lessons as $lesson)
                            @php
                                // Check if this lesson is active based on URL
                                $isActiveLesson =
                                    url()->current() ===
                                    route('lesson.show', [
                                        'module' => $module->slug,
                                        'lesson' => $lesson->slug,
                                    ]);
                            @endphp

                            <a href="{{ route('lesson.show', ['module' => $module->slug, 'lesson' => $lesson->slug]) }}"
                                class="block border-2 border-red-500 px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition-colors {{ $isActiveLesson ? 'text-w3schools dark:text-w3schools-light font-medium' : 'text-gray-700 dark:text-gray-300' }}">
                                {{ $lesson->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</aside>
