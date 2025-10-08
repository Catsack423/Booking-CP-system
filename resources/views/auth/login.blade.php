<x-guest-layout>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <div class="rb-center">
    <div id="login-card">
      <img src="{{ asset('images/logo-room-booking.png') }}" alt="logo" class="rb-logo">
      <div class="rb-title">Sign in</div>

      <ul class="notifications" style="position:fixed;top:30px;right:20px;z-index:9999;"></ul>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="rb-group">
          <label for="email" class="rb-label">Email</label>
          <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                 placeholder="Email address" class="rb-input">
        </div>

        <div class="rb-group">
          <label for="password" class="rb-label">Password</label>
          <input id="password" name="password" type="password" required placeholder="Password" class="rb-input">
        </div>

        <div class="rb-row">
          <label class="rb-check">
            <input type="checkbox" name="remember"> Remember me
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" style="font-size:14px;color:#4b5563">Forgot Password?</a>
          @endif
        </div>

        <button type="submit" class="rb-btn primary">Login</button>

        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="rb-btn secondary">Register</a>
        @endif
      </form>
    </div>
  </div>

  <script>
    const notifications = document.querySelector(".notifications");
    const toastDetails = {
      success: { icon: 'fa-circle-check',         defaultText: 'สำเร็จ' },
      error:   { icon: 'fa-circle-xmark',         defaultText: 'เกิดข้อผิดพลาด' },
      warning: { icon: 'fa-triangle-exclamation', defaultText: 'กรุณาตรวจสอบข้อมูล' },
      info:    { icon: 'fa-circle-info',          defaultText: 'ข้อมูล' },
    };
    const removeToast = (toast) => {
      toast.classList.add("hide");
      if (toast.timeoutId) clearTimeout(toast.timeoutId);
      setTimeout(() => toast.remove(), 500);
    };
    const createToast = (id, text = null, duration = 5000) => {
      const conf = toastDetails[id] || toastDetails.info;
      const toast = document.createElement("li");
      toast.className = `toast ${id}`;
      toast.style.setProperty('--timer', duration + 'ms');
      toast.innerHTML = `
        <div class="column">
          <i class="fa-solid ${conf.icon}"></i>
          <span>${(text ?? conf.defaultText).toString().replace(/\n/g,'<br>')}</span>
        </div>
        <i class="fa-solid fa-xmark" aria-label="Close"></i>
      `;
      notifications.appendChild(toast);
      toast.querySelector(".fa-xmark").addEventListener("click", () => removeToast(toast));
      toast.timeoutId = setTimeout(() => removeToast(toast), duration);
    };

    @if ($errors->any())
      createToast('error', {!! json_encode(implode("\n", $errors->all())) !!}, 7000);
    @endif

    @if (session('status'))
      createToast('info', @json(session('status')), 5000);
    @endif
  </script>
</x-guest-layout>
