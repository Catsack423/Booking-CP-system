<x-guest-layout>
    {{-- CSS เฉพาะหน้านี้:}}
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
    .rb-input{
      width:100%;padding:10px 14px;border-radius:12px;border:1px solid #d1d5db;
      background:#fff;box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.25);box-shadow:inset 0 4px 3px rgba(0, 0, 0, 0.25);
    }
    .rb-input:focus{
      outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.20), inset 0 1px 2px rgba(0,0,0,.08)
    }
    .rb-row{max-width:480px;margin:8px auto 0;display:flex;align-items:center;justify-content:space-between}
    .rb-check{display:flex;align-items:center;font-size:14px;color:#4b5563}
    .rb-check input{margin-right:8px}
    .rb-btn{display:block;width:480px;max-width:100%;margin:14px auto 0;padding:12px 0;border-radius:12px;
      text-align:center;font-weight:600;box-shadow:0 6px 0 rgba(0,0,0,.12);text-decoration:none}
    .rb-btn.primary{background:linear-gradient(#1d74d6,#0f5fbf);color:#fff}
    .rb-btn.primary:hover{filter:brightness(0.85)}
    .rb-btn.secondary{background:#e5e7eb;color:#374151}
    .rb-btn.secondary:hover{background:#dcdfe4}
  </style>
<script>
    function checkEmail(){
        let cpass = document.getElementById("password").value
        if(cpass.length == 0){
            alert("กรุณากรอก Password ก่อน!!!")
        }
    }
</script>
  <div class="rb-center">
    <div id="login-card">
      <img src="{{ asset('images/logo-room-booking.png') }}" alt="logo" class="rb-logo" >
      <div class="rb-title">Welcome Admin!</div>

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
            <input id="password" name="password" type="password" required placeholder="Password" class="rb-input"
                onblur="checkEmail()">
        </div>

        <div class="rb-row">
            <label class="rb-check">
                <input type="checkbox" name="remember"> Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:14px;color:#4b5563">Forgot Password</a>
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
