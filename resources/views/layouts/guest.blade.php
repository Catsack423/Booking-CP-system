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


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <style>
        /* BG เต็มจอ + เบลอ */
        body {
            min-height: 20vh;
            margin: 0;
        }
        .bg-full {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }
        .bg-full img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(4px);
            transform: scale(1.0);
        }
        .bg-overlay {
            position: absolute;
        }
        main {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
    </style>
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
