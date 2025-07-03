{{-- <div>
    <!-- Error Message -->
    @error('email') 
        <p class="text-red-500 text-sm mb-4">{{ $message }}</p> 
    @enderror

    <form wire:submit.prevent="login">
        <div class="mb-4">
            <input 
                wire:model="email"
                type="email" 
                placeholder="Email" 
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
            >
        </div>
        <div class="mb-4">
            <input 
                wire:model="password"
                type="password" 
                placeholder="Password" 
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
            >
        </div>
        <div class="flex justify-between items-center mb-4">
            <label class="flex items-center">
                <input wire:model="remember" type="checkbox" class="rounded dark:bg-gray-700">
                <span class="ml-2 text-sm dark:text-gray-300">Remember me</span>
            </label>
            <a href="/forgot-password" class="text-sm text-blue-600 hover:underline dark:text-blue-400">Forgot password?</a>
        </div>
        <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
            Sign in
        </button>
    </form>

    <p class="mt-4 text-center text-gray-600 dark:text-gray-300">
        Don't have an account? <a href="/register" class="text-blue-600 hover:underline dark:text-blue-400">Register</a>
    </p>
</div> --}}




<div>
    <!-- Show when guest (not logged in) -->
    @guest
        <button 
            @click="showModal = true" 
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors"
        >
            Sign in
        </button>
    @endguest

    <!-- Show when authenticated -->
    @auth
        <div x-data="{ open: false }" class="relative">
            <button 
                @click="open = !open" 
                class="flex items-center space-x-2 focus:outline-none"
            >
                <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div 
                x-show="open" 
                @click.away="open = false" 
                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
            >
                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                </div>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Edit Profile</a>
                <button 
                    wire:click="logout" 
                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    Logout
                </button>
            </div>
        </div>
    @endauth

    <!-- Login Modal (keep your existing modal code) -->
    <div 
        x-show="showModal" 
        @keydown.escape.window="showModal = false" 
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <!-- Your existing modal content -->
    </div>
</div>