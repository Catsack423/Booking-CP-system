<div class="navbar">
  <!-- แถวบน -->
  <div class="navbar-top">
    {{-- <img src="{{ asset('img/logo.png') }}" alt="logo"> --}}
    <div class="navbar-user">
      <span>pawat.pa@kkumail.com</span>
      <img src="{{ asset('img/test-account.png') }}" alt="user"> 
    </div>
  </div>

  <!-- แถวล่าง -->
  <div class="navbar-bottom">
    <div class="navbar-logo">
      <img src="{{ asset('img/logo.png') }}" alt="logo">
    </div>
    <div class="navbar-menu">
      <a href="{{ route('floor1') }}" class="{{ request()->routeIs('floor1') ? 'active' : '' }}">ชั้น 1</a>
      <a href="{{ route('floor2') }}" class="{{ request()->routeIs('floor2') ? 'active' : '' }}">ชั้น 2</a>
      <a href="{{ route('floor4') }}" class="{{ request()->routeIs('floor4') ? 'active' : '' }}">ชั้น 4</a>
      <a href="{{ route('floor5') }}" class="{{ request()->routeIs('floor5') ? 'active' : '' }}">ชั้น 5</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">เกี่ยวกับเรา</a>
      <a href="{{ route('guide') }}" class="{{ request()->routeIs('guide') ? 'active' : '' }}">วิธีใช้งาน</a>
      <img src="{{ asset('img/logout.png') }}" alt="logout" class="logout-btn">
    </div>
  </div>
</div>
