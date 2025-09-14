{{-- resources/views/auth/reset-password.blade.php --}}
<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/Resetpass.css') }}">
    <div class="rb-center">
      <div id="reset-card">
        {{-- โลโก้เล็กด้านบน: เปลี่ยนเป็นไฟล์ของพี่ (วางไว้ public/img/logo-mini.png) --}}
        <img src="{{ asset('images/logo-room-booking.png') }}" alt="Logo" class="rb-logo-mini">
        <h2 class="rb-title">Reset Password</h2>

        {{-- error ของ Jetstream --}}
        <x-validation-errors class="mb-3" />

        {{-- ฟอร์มรีเซ็ตรหัสผ่าน --}}
        <form method="POST" action="{{ route('password.update') }}">
          @csrf
          {{-- ใช้ request() เพื่อเลี่ยงตัวแปร $request --}}
          <input type="hidden" name="token" value="{{ request()->route('token') }}">

          <div class="mb-3">
            <label class="rb-label" for="email">Email</label>
            <input id="email" name="email" type="email"
                   class="rb-input"
                   value="{{ request('email', old('email')) }}"
                   readonly>
          </div>

          <div class="mb-3">
            <label class="rb-label" for="password">Password</label>
            <input id="password" name="password" type="password" class="rb-input" required autocomplete="new-password">
          </div>

          <div class="mb-4">
            <label class="rb-label" for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="rb-input" required autocomplete="new-password">
          </div>

          <button type="submit" class="rb-btn">RESET PASSWORD</button>
        </form>
      </div>
    </div>
</x-guest-layout>
