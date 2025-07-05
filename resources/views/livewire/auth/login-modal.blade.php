<div x-data="{ open: false, mode: 'login' }" x-on:open-login-modal.window="open = true; mode = 'login'"
    x-on:close-login-modal.window="open = false" x-show="open" x-transition x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white dark:bg-gray-800 w-full max-w-md mx-auto p-6 rounded-lg shadow-lg relative">
        <button @click="open = false"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100">
            &times;
        </button>

        <!-- Login Form -->
        <div x-show="mode === 'login'" class="space-y-4">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">Sign in</h2>
            <p class="text-center text-gray-600 dark:text-gray-300 mt-2 mb-6">Get access to more learning features</p>

            <div class="grid grid-cols-1 gap-2 mb-4">
                <!-- In both login and register sections -->
                <button
                    class="w-full bg-white dark:bg-gray-700 text-gray-800 dark:text-white px-4 py-2 rounded-lg flex items-center justify-center border hover:bg-gray-100 dark:hover:bg-gray-600 transition">

                    <x-google-icon />
                    Continue with Google
                </button>


            </div>

            <!-- Divider -->
            <div class="flex items-center my-4">
                <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                <span class="mx-4 text-gray-500 dark:text-gray-400">or</span>
                <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
            </div>

            <form wire:submit.prevent="login">
                @if ($error)
                    <div class="text-red-600 mb-4 text-center">{{ $error }}</div>
                @endif

                <div class="mb-4">
                    <input type="email" wire:model.defer="email" required placeholder="Enter your email"
                        class="w-full px-4 py-3 border rounded-lg text-gray-700 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <input type="password" wire:model.defer="password" required placeholder="Enter your password"
                        class="w-full px-4 py-3 border rounded-lg text-gray-700 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <x-submit-btn>Login</x-submit-btn>

            </form>

            <!-- "Don’t have an account?" Section -->
            <p class="text-center text-gray-600 dark:text-gray-400 mt-4">
                Don't have an account?
                <button @click="mode = 'register'" class="text-blue-600 hover:underline font-medium">Register</button>
            </p>

            <!-- Forgot Password Link -->
            <p class="text-center mt-6">
                <button class="text-blue-600 hover:underline text-sm">Forgot your password?</button>
            </p>
        </div>

        

        <!-- Register Form -->
        <form x-show="mode === 'register'" wire:submit.prevent="register" class="space-y-4">

            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">Register</h2>
            <p class="text-center text-gray-600 dark:text-gray-300 mt-2 mb-6">Create your account</p>

            <div class="grid grid-cols-1 gap-2 mb-4">
                <button type="button"
                    class="w-full bg-white dark:bg-gray-700 text-gray-800 dark:text-white px-4 py-2 rounded-lg flex items-center justify-center border hover:bg-gray-100 dark:hover:bg-gray-600 transition">

                    <x-google-icon />

                    Continue with Google
                </button>
            </div>

            <!-- Divider -->
            <div class="flex items-center my-4">
                <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                <span class="mx-4 text-gray-500 dark:text-gray-400">or</span>
                <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
            </div>

            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Name</label>
                <input type="text" wire:model.defer="name"
                    class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Email</label>
                <input type="email" wire:model.defer="email"
                    class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Password</label>
                <input type="password" wire:model.defer="password"
                    class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <x-submit-btn loader="register">Register</x-submit-btn>

            <p class="text-center text-gray-600 dark:text-gray-400 mt-4">
                Already have an account?
                <button @click="mode = 'login'" class="text-blue-600 hover:underline font-medium">Sign In</button>
            </p>
        </form>
    </div>
</div>
