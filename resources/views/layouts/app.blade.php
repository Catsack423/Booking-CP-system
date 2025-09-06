<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'ระบบจองห้อง')</title>
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
