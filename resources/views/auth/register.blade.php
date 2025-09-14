<x-guest-layout>

<link rel="stylesheet" href="css/register.css">

    <script>
        function validateForm() {
            let cBox = document.getElementById("cBox");
            if (!cBox.checked) {
                alert("กรุณาติ๊ก I Accept the Terms and Conditions ก่อนลงทะเบียน!");
                return false; // ยกเลิก submit
            }
            return true; // อนุญาตให้ submit
        }
    </script>
    <div class="rb-center">
        <div id="login-card">
            <img src="{{ asset('images/logo-room-booking.png') }}" alt="logo" class="rb-logo"
                style="width:300px;height:150px;object-fit:contain">

            <div class="rb-title">Register</div>


            <x-validation-errors class="rb-group" />

            <form method="POST" action="{{ route('register') }}">
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
                        autocomplete="new-password" placeholder="Password">
                </div>

                <div class="rb-group">
                    <label for="password_confirmation" class="rb-label">Repeat Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="rb-input"
                        required autocomplete="new-password" placeholder="Repeat Password">
                </div>

                <div class="rb-row">
                    <label class="rb-check">
                        <input type="checkbox" name="" id="cBox" require> I Accept the Terms and Conditions
                    </label>

                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="rb-group">
                        <label class="rb-check">
                            <input type="checkbox" id="cBox" required> I Accept the Terms and Conditions
                        </label>
                        <div style="font-size:12px;margin-top:6px">
                            {!! __('อ่านเพิ่มเติม: :terms_of_service และ :privacy_policy', [
                                'terms_of_service' =>
                                    '<a target="_blank" href="' . route('terms.show') . '" class="underline">Terms of Service</a>',
                                'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="underline">Privacy Policy</a>',
                            ]) !!}
                        </div>
                    </div>
                @endif


                <button type="submit" class="rb-btn primary" onclick="return validateForm()">Register</button> <br>
                <div class="rb-group">
                    <label for="">มีรหัสแล้วอยู่หรือป่าว?</label> <a href="{{ route('login') }} "
                        class="clicktologin">ถ้ามีคลิ๊กที่นี่</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
