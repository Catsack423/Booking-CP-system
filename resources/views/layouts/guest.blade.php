<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/BGlogin.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    
</head>
<body class="font-sans antialiased">

    {{-- BG --}}
    <div class="bg-full">
        <img src="{{ asset('images/BG-login.jpg') }}" alt="bg">
        <div class="bg-overlay"></div>
    </div>

    {{-- Slot เนื้อหา --}}
    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
