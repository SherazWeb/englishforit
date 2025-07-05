<!DOCTYPE html>
<html lang="en" x-data="layout()" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Layout' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles

    <style>
        x-cloak {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans transition-colors duration-200">

    @include('partials.header')

    @livewire('auth.login-modal')

    {{ $slot }}

    @vite('resources/js/app.js')
    @livewireScripts

    <script>
        function layout() {
            return {
                sidebarOpen: true,
                darkMode: true,
                mobileSidebarOpen: false
            }
        }
    </script>
</body>
</html>
