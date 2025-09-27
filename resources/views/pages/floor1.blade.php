@extends('layouts.app')

@section('title', 'Floor 1')
<link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
<link rel="stylesheet" href="{{ asset('css/room.css') }}">
<link rel="stylesheet" href="{{ asset('css/toast.css') }}"><!-- ✅ Toast -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    #CP9127 {
        top: 37.8%;
        left: 19.8%;
    }
</style>

@section('content')
    <ul class="notifications" style="position:fixed;top:30px;right:20px;z-index:9999;"></ul>

    <body style="background: rgba(119, 118, 118, 0.137);">
        <?php $now = date('Y-m-d'); ?>
        <div class="floor-plan">
            <h1 style="margin-left: 60px; font-size: 30px; text-decoration: underline;">ชั้น 1</h1><br>
            <div class="map-wrapper">
                <img src="{{ asset('img/floor1map.png') }}" alt="Error">
                @foreach ($rooms as $room)
                    @if ($room->status == false)
                        <a href="/booking/{{ $floor }}/{{ $room->id }}/{{ $now }}"
                            class="{{ request()->routeIs('booking.*') ? 'active' : '' }}">
                            <button id="{{ $room->id }}" title="{{ $room->id }}" class="room-btn"></button>
                        </a>
                    @else
                        <a href="/booking/{{ $floor }}/{{ $room->id }}/{{ $now }}"
                            class="{{ request()->routeIs('booking.*') ? 'active' : '' }}">
                            <button id="{{ $room->id }}" title="{{ $room->id }}"
                                class="room-btn-notavailable"></button>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </body>

    {{-- โชว์"เข้าสู่ระบบสำเร็จ" --}}
    <script>
        const notifications = document.querySelector(".notifications");
        const toastDetails = {
            success: {
                icon: 'fa-circle-check',
                defaultText: 'สำเร็จ'
            },
            error: {
                icon: 'fa-circle-xmark',
                defaultText: 'เกิดข้อผิดพลาด'
            },
        };
        const removeToast = (toast) => {
            toast.classList.add("hide");
            if (toast.timeoutId) clearTimeout(toast.timeoutId);
            setTimeout(() => toast.remove(), 500);
        };
        const createToast = (id, text = null, duration = 4500) => {
            const conf = toastDetails[id] || toastDetails.success;
            const toast = document.createElement("li");
            toast.className = `toast ${id}`;
            toast.style.setProperty('--timer', duration + 'ms');
            toast.innerHTML = `
        <div class="column">
          <i class="fa-solid ${conf.icon}"></i>
          <span>${(text ?? conf.defaultText).toString()}</span>
        </div>
        <i class="fa-solid fa-xmark" aria-label="Close"></i>
      `;
            notifications.appendChild(toast);
            toast.querySelector(".fa-xmark").addEventListener("click", () => removeToast(toast));
            toast.timeoutId = setTimeout(() => removeToast(toast), duration);
        };

        @if (session('success'))
            createToast('success', @json(session('success')), 4000); 
        @endif
    </script>
@endsection
