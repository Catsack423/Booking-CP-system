<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'ระบบจองห้อง')</title>
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/history.css') }}">
  <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  @include('components.navbar')

  <!-- Content -->
  <main style="padding:20px;">
    @yield('content')
  </main>
</body>
</html>
