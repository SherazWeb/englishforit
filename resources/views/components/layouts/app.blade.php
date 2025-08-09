<!DOCTYPE html>
<html lang="en" x-data="layout()" :class="darkMode ? 'dark' : ''" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Layout' }}</title>

    @vite('resources/css/app.css')
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans transition-colors duration-200">

    {{-- Header --}}
    @include('partials.header')

    {{-- Login Modal --}}
    @livewire('auth.login-modal')

    {{-- Page Content --}}
    {{ $slot }}

    @vite('resources/js/app.js')
    @livewireScripts

    <script>
        function layout() {
            return {
                sidebarOpen: true,
                darkMode: true, // default: dark mode enabled
                mobileSidebarOpen: false,

                init() {
                    // Load preference from localStorage if available
                    const storedDark = localStorage.getItem('darkMode');
                    if (storedDark !== null) {
                        this.darkMode = storedDark === 'true';
                    } else {
                        this.darkMode = true; // Default to dark mode
                    }

                    // Watch for changes and store them
                    this.$watch('darkMode', (value) => {
                        localStorage.setItem('darkMode', value);
                    });
                }
            }
        }
    </script>
</body>
</html>
