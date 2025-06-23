<!DOCTYPE html>
<html lang="en" x-data="{
    sidebarOpen: true,
    activeModule: null,
    activeSubTopic: null,
    darkMode: true,
    mobileSidebarOpen: false
}" :class="darkMode ? 'dark' : ''">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-sans transition-colors duration-200">
    <!-- Header -->
    <header
        class="bg-white dark:bg-gray-800 shadow-sm fixed top-0 left-0 right-0 z-20 border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="text-xl font-bold text-gray-800 dark:text-white">My Learning Site</div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Dark mode toggle -->
                    <button @click="darkMode = !darkMode"
                        class="p-2 rounded-full focus:outline-none bg-gray-200 dark:bg-gray-700">
                        <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                        <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-300"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Mobile menu button -->
                    <button class="md:hidden" @click="mobileSidebarOpen = !mobileSidebarOpen">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 dark:text-gray-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Subheader -->
    <div class="bg-w3schools-light dark:bg-w3schools-darker mt-14 sticky top-14">
        <div class="container mx-auto px-4 py-2">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Current Module</h2>
                <button class="md:hidden text-white" @click="mobileSidebarOpen = !mobileSidebarOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex">
        <!-- Sidebar -->
        <aside
            class="w-64 bg-white dark:bg-gray-800 shadow-md fixed h-[calc(100vh-5rem)] z-10 transition-all duration-300 ease-in-out border-r border-gray-200 dark:border-gray-700"
            :class="mobileSidebarOpen ? 'left-0' : '-left-64 md:left-0'">
            <div class="overflow-y-auto h-full pb-20">
                <div class="px-4 py-2">
                    <h3 class="font-bold text-lg mb-2 dark:text-white">Modules</h3>
                    <div class="space-y-1">
                        @foreach ($modules as $module)
                            <div x-data="{
                                open: activeModule === {{ $module->id }},
                                localActiveLesson: null
                            }">
                                <button
                                    @click="
                            activeModule = activeModule === {{ $module->id }} ? null : {{ $module->id }};
                            open = !open;
                            if (!open) {
                                localActiveLesson = null;
                                activeSubTopic = null;
                            }
                        "
                                    class="w-full text-left px-2 py-2 bg-gray-100 dark:bg-gray-700 rounded flex justify-between items-center hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                                    :class="activeModule === {{ $module->id }} ?
                                        'text-w3schools dark:text-w3schools-light font-semibold' :
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
                                        <a href="{{ route('lesson.show', ['module' => $module->slug, 'lesson' => $lesson->slug]) }}"
                                            @click="
        activeSubTopic = '{{ $lesson->id }}';
        localActiveLesson = '{{ $lesson->id }}';
        mobileSidebarOpen = false;
    "
                                            class="block px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition-colors"
                                            :class="activeSubTopic === '{{ $lesson->id }}' ?
                                                'text-w3schools dark:text-w3schools-light font-medium' :
                                                'text-gray-700 dark:text-gray-300'">
                                            {{ $lesson->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-0 md:ml-64 transition-all duration-300 ease-in-out">
            <div class="container mx-auto px-4 py-6 space-y-6">

                <!-- Listening Section -->
                @if (!empty($contents))
                    <section class="bg-white dark:bg-gray-800 rounded-lg shadow p-6" x-data="{ showText: false }">
                        <h2 class="text-2xl font-bold mb-4 dark:text-white">🎧 {{ $contents->title }}</h2>

                        <!-- Audio Player -->
                        @if ($contents->listening_audio_path)
                            <audio controls class="w-full mb-4">
                                <source src="{{ asset($contents->listening_audio_path) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        @endif

                        <!-- Toggle Button -->
                        @if ($contents->listening_transcript)
                            <button @click="showText = !showText"
                                class="mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                                <span x-show="!showText">🔽 Show Conversation</span>
                                <span x-show="showText">🔼 Hide Conversation</span>
                            </button>
                        @endif

                        <!-- Hidden Text -->
                        <div x-show="showText" x-transition class="text-gray-700 dark:text-gray-300 space-y-2">
                            {!! $contents->listening_transcript !!}
                        </div>
                    </section>

                    <!-- Reading Section -->
                    <section class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h2 class="text-2xl font-bold mb-4 dark:text-white">📖 Reading</h2>
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! $contents->reading_content !!}
                        </div>

                        @if ($contents->reading_vocabulary)
                            <div class="mt-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">Vocabulary</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach ($contents->reading_vocabulary as $item)
                                        <div
                                            class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100 p-3 rounded-lg shadow-sm">
                                            <strong class="text-gray-900 dark:text-white">{{ $item['term'] }}:</strong>
                                            <span class="block mt-1">{{ $item['definition'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </section>
                @endif

                @if (!empty($contents->quiz) && $contents->quiz->questions->count())
                    @foreach ($contents->quiz->questions as $question)
                        <livewire:quiz-submission :question-id="$question->id" :key="$question->id" />
                    @endforeach
                @endif


                <!-- ✍️ Writing -->
                @if (!empty($contents))
                    @livewire('lesson-writing-form', ['lessonId' => $contents->id, 'prompt' => $contents->writing_prompt])
                @endif

            </div>
        </main>

    </div>

    @vite('resources/js/app.js')
    @livewireScripts
</body>

</html>
