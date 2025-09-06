<x-guest-layout>
    <style>
        .rb-center{display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px}
    #login-card{
      width:720px;max-width:92vw;
      background:rgba(255,255,255,.92);
      border-radius:22px;
      border:1px solid rgba(0,0,0,.08);
      box-shadow:0 20px 40px rgba(0,0,0,.20), inset 0 1px 0 rgba(255,255,255,.5);
      padding:40px 48px
    }
    .rb-logo{width: 300; height:150px;display:block;margin:0 auto}
    .rb-title{margin:14px 0 22px;text-align:center;color:#111827;font-size:27px;font-weight:500}
    .rb-group{max-width:480px;margin:0 auto 16px}
    .rb-label{display:block;font-size:14px;color:#374151;margin-bottom:6px}
    .rb-btn.primary{background-color: #0B76BC;color:#fff}
    .rb-btn.primary:hover{filter:brightness(0.85)}
    .rb-row{max-width:480px;margin:8px auto 0;display:flex;align-items:center;justify-content:space-between}
    .rb-check{display:flex;align-items:center;font-size:14px;color:#4b5563}
    .rb-check input{margin-right:8px}
    .rb-btn{display:block;width:480px;max-width:100%;margin:14px auto 0;padding:12px 0;border-radius:12px;
      text-align:center;font-weight:600;box-shadow:0 6px 0 rgba(0,0,0,.12);text-decoration:none}
    .rb-input{
      width:100%;padding:10px 14px;border-radius:12px;border:1px solid #d1d5db;
      background:#fff;box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.25);box-shadow:inset 0 4px 3px rgba(0, 0, 0, 0.25);
    }
    .rb-input:focus{
      outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.20), inset 0 1px 2px rgba(0,0,0,.08)
    }
    </style>
    <div class="rb-center">
        <div id="login-card">
        <img src="{{ asset('images/logo-room-booking.png') }}" alt="logo" class="rb-logo" style="width:300px;height:150px;object-fit:contain">
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
                <x-input id="email" class="block mt-1 w-full" placeholder="กรุณากรอกอีเมล" type="email" name="email" :value="old('email')"  required autofocus autocomplete="username" />
            </div>

            <div class="rb-btn.primary">
                <button type="submit" class="rb-btn primary" >RESET LINK TO EMAIL YOU</button> <br> 
            </div>
        </form>

</x-guest-layout>
