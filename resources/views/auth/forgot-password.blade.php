<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/Forgot.css') }}">

    <div class="rb-center">
        <div id="login-card">
            <img src="{{ asset('images/logo-room-booking.png') }}" alt="logo" class="rb-logo"
                style="width:300px;height:150px;object-fit:contain">
            <div class="rb-title">Forgot Password ?</div>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('ลืมรหัสผ่านใช่ไหม? ไม่มีปัญหา เพียงแจ้งที่อยู่อีเมลของคุณ แล้วเราจะส่งลิงก์รีเซ็ตรหัสผ่านให้คุณทางอีเมล ซึ่งคุณสามารถใช้เลือกรหัสผ่านใหม่ได้') }}
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="block">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" placeholder="กรุณากรอกอีเมล" type="email"
                        name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="rb-btn.primary">
                    <button type="submit" class="rb-btn primary">RESET LINK TO EMAIL YOU</button> <br>
                </div>
            </form>

</x-guest-layout>
