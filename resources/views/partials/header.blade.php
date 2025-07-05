<header
    class="bg-white dark:bg-gray-800 shadow-sm fixed top-0 left-0 right-0 z-20 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <div class="text-xl font-bold text-gray-800 dark:text-white">My Learning Site</div>

        <div class="flex items-center gap-4">
            <!-- Dark mode toggle -->
            <button @click="darkMode = !darkMode"
                class="p-2 rounded-full focus:outline-none bg-gray-200 dark:bg-gray-700">
                <template x-if="!darkMode">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                </template>
                <template x-if="darkMode">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-300" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            clip-rule="evenodd" />
                    </svg>
                </template>
            </button>

            @guest
                <button @click="$dispatch('open-login-modal')"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Sign In
                </button>
            @endguest

            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 rounded-full border border-gray-300 dark:border-gray-600">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-sm font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 shadow-lg rounded-lg z-50 py-4">

                        <!-- User Info -->
                        <div class="mb-2 p-3">
                            <p class="font-semibold text-gray-800 dark:text-white">{{ Auth::user()->name }}</p>
                        </div>

                        <!-- Progress Bar -->
                        {{-- <div class="mb-4">
                            <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">Python • Tutorial</div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded h-2">
                                <div class="bg-green-500 h-2 rounded" style="width: 1%;"></div>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span>1% Completed</span> · <a href="#"
                                    class="text-green-500 hover:underline">Resume</a>
                            </div>
                        </div> --}}

                        <!-- Menu Links -->
                        <ul class="space-y-2 text-gray-700 dark:text-gray-200">
                            <x-dropdown-item href="/">Dashboard</x-dropdown-item>
                        </ul>

                        <!-- Logout -->
                        <div class="mt-1">
                            <livewire:auth.logout-button />
                        </div>
                    </div>
                </div>
            @endauth

        </div>
    </div>
</header>
