<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/Login.css') }}">

    <script>
        function checkEmail() {
            let cpass = document.getElementById("password").value
            if (cpass.length == 0) {
                alert("กรุณากรอก Password ก่อน!!!")
            }
        }
    </script>
    <div class="rb-center">
        <div id="login-card">
            <img src="{{ asset('images/logo-room-booking.png') }}" alt="logo" class="rb-logo">
            <div class="rb-title">sign in</div>

            {{-- errors / status --}}
            <x-validation-errors />
            @if (session('status'))
                <div class="rb-group" style="color:#059669;font-size:14px">{{ session('status') }}</div>
            @endif

            {{-- ฟอร์ม --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="rb-group">
                    <label for="email" class="rb-label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        placeholder="Email address" class="rb-input">
                </div>

                <div class="rb-group">
                    <label for="password" class="rb-label">Password</label>
                    <input id="password" name="password" type="password" required placeholder="Password"
                        class="rb-input" onblur="checkEmail()">
                </div>

                <div class="rb-row">
                    <label class="rb-check">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:14px;color:#4b5563">Forgot
                            Password</a>
                    @endif
                </div>

                <button type="submit" class="rb-btn primary">Login</button>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="rb-btn secondary">Register</a>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>
