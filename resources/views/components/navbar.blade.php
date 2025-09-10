<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8" />
  <title>Navbar Frame</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="navbar">
    <div class="navbar-logo">
      <img src="{{ asset('img/logo.png') }}" alt="logo">
    </div>

    <div class="navbar-top">
      <div class="navbar-user">
        <span>{{auth()->user()->getEmailAddressAttribute()}}</span>
        <img src="{{ asset('img/test-account.png') }}" alt="user">
      </div>
    </div>

    <div class="navbar-bottom">
      <div class="navbar-menu">
        <a href="{{ route('floor1') }}" class="{{ request()->routeIs('floor1') ? 'active' : '' }}">ชั้น 1</a>
        <a href="{{ route('floor2') }}" class="{{ request()->routeIs('floor2') ? 'active' : '' }}">ชั้น 2</a>
        <a href="{{ route('floor4') }}" class="{{ request()->routeIs('floor4') ? 'active' : '' }}">ชั้น 4</a>
        <a href="{{ route('floor5') }}" class="{{ request()->routeIs('floor5') ? 'active' : '' }}">ชั้น 5</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">เกี่ยวกับเรา</a>
        <a href="{{ route('guide') }}" class="{{ request()->routeIs('guide') ? 'active' : '' }}">วิธีใช้งาน</a>

        <form method="POST" action="{{ route('logout') }}" class="logout-form">
    @csrf
    <button type="submit" class="logout-btn" title="logout">
        <img src="{{ asset('img/logout.png') }}" alt="logout" title="logout">
    </button>
</form>


      </div>
    </div>
  </div>
</body>
</html>
