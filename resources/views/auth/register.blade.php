<x-guest-layout>
    <style>
        .rb-center {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px
        }

        #login-card {
            width: 720px;
            max-width: 92vw;
            background: rgba(255, 255, 255, .92);
            border-radius: 22px;
            border: 1px solid rgba(0, 0, 0, .08);
            box-shadow: 0 20px 40px rgba(0, 0, 0, .20), inset 0 1px 0 rgba(255, 255, 255, .5);
            padding: 40px 48px
        }

        .rb-logo {
            width: 300;
            height: 150px;
            display: block;
            margin: 0 auto
        }

        .rb-title {
            margin: 14px 0 22px;
            text-align: center;
            color: #111827;
            font-size: 27px;
            font-weight: 500
        }

        .rb-group {
            max-width: 480px;
            margin: 0 auto 16px
        }

        .rb-label {
            display: block;
            font-size: 14px;
            color: #374151;
            margin-bottom: 6px
        }

        .rb-input {
            width: 100%;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            background: #fff;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.25);
        }

        .rb-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .20), inset 0 1px 2px rgba(0, 0, 0, .08)
        }

        .rb-row {
            max-width: 480px;
            margin: 8px auto 0;
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .rb-check {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #4b5563
        }

        .rb-check input {
            margin-right: 8px
        }

        .rb-btn {
            display: block;
            width: 480px;
            max-width: 100%;
            margin: 14px auto 0;
            padding: 12px 0;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 6px 0 rgba(0, 0, 0, .12);
            text-decoration: none
        }

        .rb-btn.primary {
            background-color: #0B76BC;
            color: #fff
        }

        .rb-btn.primary:hover {
            filter: brightness(0.85)
        }

        .rb-btn.secondary {
            background: #e5e7eb;
            color: #374151
        }

        .rb-btn.secondary:hover {
            background: #dcdfe4
        }

        .clicktologin {
            color: #0B76BC;
        }
    </style>

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
                <label for="">มีรหัสแล้วอยู่หรือป่าว?</label> <a href="{{ route('login') }} "
                    class="clicktologin">ถ้ามีคลิ๊กที่นี่</a>

            </form>
        </div>
    </div>
</x-guest-layout>
