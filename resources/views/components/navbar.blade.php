<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <title>Navbar & Sidebar</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="navbar">
        <!-- Logo -->
        <div class="navbar-logo">
            <a href="../../floor1">
                <img src="{{ asset('img/logo.png') }}" alt="logo">
            </a>
        </div>

        <!-- User Info (Desktop only) -->
        <div class="navbar-top desktop-only">
            <div class="navbar-user">
                <span>
                    <div class="col-span-6 sm:col-span-4 mt-4">
                        <p class="mt-1 block w-full border rounded px-3 py-2 bg-gray-100 text-gray-700">
                            {{ $state['email'] ?? Auth::user()->email }}
                        </p>
                    </div>
                </span>
                <a href="../profile">
                    <div class="cardProfile-img">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="avatar" class="user-avatar"
                            style="border-radius: 50px;">
                    </div>
                </a>
            </div>
        </div>

<<<<<<< HEAD

        <div class="navbar-bottom">
=======
        <!-- Menu (Desktop only) -->
        <div class="navbar-bottom desktop-only">
>>>>>>> 710d257 (Update Profile and nav Sidebar Menu)
            <div class="navbar-menu">
                <a href="{{ route('floor1') }}" class="{{ request()->routeIs('floor1') ? 'active' : '' }}">ชั้น 1</a>
                <a href="{{ route('floor2') }}" class="{{ request()->routeIs('floor2') ? 'active' : '' }}">ชั้น 2</a>
                <a href="{{ route('floor4') }}" class="{{ request()->routeIs('floor4') ? 'active' : '' }}">ชั้น 4</a>
                <a href="{{ route('floor5') }}" class="{{ request()->routeIs('floor5') ? 'active' : '' }}">ชั้น 5</a>
<<<<<<< HEAD
                <a href="{{ route('about') }}"
                    class="{{ request()->routeIs('about') ? 'active' : '' }}">เกี่ยวกับเรา</a>
                <a href="{{ route('guide') }}"
                    class="{{ request()->routeIs('guide') ? 'active' : '' }}">วิธีใช้งาน</a>


=======
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">เกี่ยวกับเรา</a>
                <a href="{{ route('guide') }}" class="{{ request()->routeIs('guide') ? 'active' : '' }}">วิธีใช้งาน</a>
>>>>>>> 710d257 (Update Profile and nav Sidebar Menu)
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <img src="{{ asset('img/logout.png') }}" alt="logout">
                    </button>
                </form>
<<<<<<< HEAD



=======
>>>>>>> 710d257 (Update Profile and nav Sidebar Menu)
            </div>
        </div>

        <!-- Hamburger (Mobile only) -->
        <div class="hamburger mobile-only" onclick="toggleSidebar()">☰</div>
    </div>

    <!-- Sidebar Menu (Mobile) -->
    <div id="sidebar" class="sidebar">
        <button class="close-btn" onclick="toggleSidebar()">×</button>

        <!-- Logo + Avatar + Email -->
        <div class="sidebar-logo">
            <a href="../profile">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="avatar">
            </a>
            <p class="sidebar-email">{{ $state['email'] ?? Auth::user()->email }}</p>
        </div>

        <!-- Menu -->
        <div class="sidebar-menu">
            <a href="{{ route('floor1') }}">ชั้น 1</a>
            <a href="{{ route('floor2') }}">ชั้น 2</a>
            <a href="{{ route('floor4') }}">ชั้น 4</a>
            <a href="{{ route('floor5') }}">ชั้น 5</a>
            <a href="{{ route('about') }}">เกี่ยวกับเรา</a>
            <a href="{{ route('guide') }}">วิธีใช้งาน</a>
        </div>

        <!-- Logout -->
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">ออกจากระบบ</button>
            </form>
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");
        }
    </script>
</body>

</html>
