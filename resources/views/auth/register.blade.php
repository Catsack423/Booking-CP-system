<x-guest-layout>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  <link rel="stylesheet" href="{{ asset('css/toast.css') }}"><!-- ✅ ใช้ Toast เดิม -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  {{-- ✅ Toast container --}}
  <ul class="notifications" style="position:fixed;top:30px;right:20px;z-index:9999;"></ul>

  <div class="rb-center">
    <div id="login-card">
      <img src="{{ asset('images/logo-room-booking.png') }}" alt="logo" class="rb-logo"
           style="width:300px;height:150px;object-fit:contain">
      <div class="rb-title">Register</div>

      {{-- เอา x-validation-errors ออก แล้วไปแสดงผ่าน Toast ด้านล่าง --}}
      {{-- <x-validation-errors class="rb-group" /> --}}

      <form method="POST" action="{{ route('register') }}" onsubmit="return validateForm();">
        @csrf

        <div class="rb-group">
          <label for="name" class="rb-label">Username</label>
          <input id="name" name="name" type="text" class="rb-input" value="{{ old('name') }}"
                 required autofocus autocomplete="name" placeholder="Username">
        </div>

        <div class="rb-group">
          <label for="email" class="rb-label">Email</label>
          <input id="email" name="email" type="email" class="rb-input" value="{{ old('email') }}"
                 required autocomplete="username" placeholder="Email">
        </div>

        <div class="rb-group">
          <label for="password" class="rb-label">Password</label>
          <input id="password" name="password" type="password" class="rb-input" required
                 autocomplete="new-password" placeholder="Password" minlength="8">
        </div>

        <div class="rb-group">
          <label for="password_confirmation" class="rb-label">Confirm Password</label>
          <input id="password_confirmation" name="password_confirmation" type="password" class="rb-input"
                 required autocomplete="new-password" placeholder="Confirm Password" minlength="8">
        </div>

        {{-- ✅ ใช้ checkbox เดียว ชื่อ "terms" ให้ตรงกับ Jetstream --}}
        <div class="rb-group">
          <label class="rb-check">
            <input type="checkbox" id="terms" name="terms" required>
            I Accept the Terms and Conditions
          </label>

          @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div style="font-size:12px;margin-top:6px">
              {!! __('อ่านเพิ่มเติม: :terms_of_service และ :privacy_policy', [
                  'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline">Terms of Service</a>',
                  'privacy_policy'   => '<a target="_blank" href="'.route('policy.show').'" class="underline">Privacy Policy</a>',
              ]) !!}
            </div>
          @endif
        </div>

        <button type="submit" class="rb-btn primary">Register</button> <br>
        <div class="rb-group">
          <label>มีรหัสแล้วอยู่แล้ว?</label>
          <a href="{{ route('login') }}" class="clicktologin">คลิ๊กที่นี่</a>
        </div>
      </form>
    </div>
  </div>

  {{-- ✅ Toast + Client-side validate + แสดง Server-side errors/status --}}
  <script>
    // ---- Toast helpers ----
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
    const createToast = (id, text = null, duration = 6000) => {
      const conf = toastDetails[id] || toastDetails.info;
      const toast = document.createElement("li");
      toast.className = `toast ${id}`;
      toast.style.setProperty('--timer', duration + 'ms');
      toast.innerHTML = `
        <div class="column">
          <i class="fa-solid ${conf.icon}"></i>
          <span>${(text ?? conf.defaultText).toString().replace(/\n/g, '<br>')}</span>
        </div>
        <i class="fa-solid fa-xmark" aria-label="Close"></i>
      `;
      notifications.appendChild(toast);
      toast.querySelector(".fa-xmark").addEventListener("click", () => removeToast(toast));
      toast.timeoutId = setTimeout(() => removeToast(toast), duration);
    };
    let lastToastKey=null, dedupeTimer=null;
    const createToastOnce = (id, text=null, duration=6000) => {
      const key = `${id}|${text ?? ''}`;
      if (lastToastKey === key) return;
      lastToastKey = key; clearTimeout(dedupeTimer);
      dedupeTimer = setTimeout(()=>{ lastToastKey=null; }, 800);
      createToast(id, text, duration);
    };

    // ---- Client-side validation ----
    function validateForm() {
      const errs = [];
      const name  = document.getElementById('name');
      const email = document.getElementById('email');
      const pass  = document.getElementById('password');
      const pass2 = document.getElementById('password_confirmation');
      const terms = document.getElementById('terms');

      if (!name.value.trim()) errs.push('กรุณากรอก Username');
      if (!email.value.trim()) errs.push('กรุณากรอก Email');
      // เช็ค format แบบง่าย ๆ
      if (email.value && !/^\S+@\S+\.\S+$/.test(email.value)) errs.push('รูปแบบอีเมลไม่ถูกต้อง');

      if (!pass.value) errs.push('กรุณากรอกรหัสผ่าน');
      if (pass.value && pass.value.length < 8) errs.push('รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร');
      if (!pass2.value) errs.push('กรุณากรอกยืนยันรหัสผ่าน');
      if (pass.value && pass2.value && pass.value !== pass2.value) errs.push('รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน');

      if (!terms.checked) errs.push('กรุณาติ๊ก I Accept the Terms and Conditions');

      if (errs.length) {
        createToastOnce('error', errs.join('\n'), 8000);
        return false; // ยกเลิก submit
      }
      return true; // ส่งฟอร์มต่อ
    }

    // ---- Server-side errors/status (ถ้ามี) ----
    @if ($errors->any())
      createToastOnce('error', {!! json_encode(implode("\n", $errors->all())) !!}, 8000);
    @endif

    @if (session('status'))
      createToastOnce('info', @json(session('status')), 5000);
    @endif
  </script>
</x-guest-layout>
