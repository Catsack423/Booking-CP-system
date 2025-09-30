@extends('layouts.app')

@section('title', 'Profile')
@section('hideFooter', true)
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/toast.css') }}">

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        html,
        body {
            padding: 0;
            height: 100%;
            font-family: "Noto Sans Thai UI", sans-serif;
            margin-top: 3% !important;
            background: #f5f5f5;
        }
        ul.notifications {
            position: fixed;
            top: 80px;
            right: 16px;
            z-index: 2300;
        }

        @media (max-width: 832px) {
            body {
                padding-top: 64px;
            }

            ul.notifications {
                top: 70px;
                right: 12px;
                left: 12px;
            }
        }

        @media (max-width: 640px) {
            ul.notifications {
                left: 12px;
                right: 12px;
                top: 70px;
            }
        }

        .profile-content .card {
            width: auto !important;
        }

        @media (max-width: 900px) {

            body {
                margin: 0 !important;
                padding: 64px 15px 20px !important;
                /* เผื่อ navbar fixed ด้านบน */
                min-height: auto !important;
                display: block !important;
                justify-content: initial !important;
                align-items: initial !important;
            }

            .profile-content {
                flex-direction: column !important;
                gap: 16px !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .profile-content .card {
                width: 100% !important;
                max-width: 100% !important;
                padding: 16px !important;
                border-radius: 12px;
                text-align: left;
            }

            .profile-content .user-avatar {
                width: 96px;
                height: 96px;
            }

            .actionsedit {
                display: grid !important;
                grid-template-columns: 1fr !important;
                gap: 12px !important;
                margin: 10px 0 16px;
            }

            .actionsedit a,
            .profile-content button {
                width: 100% !important;
                text-align: center !important;
                padding: 12px 16px;
                border-radius: 14px;
            }
        }

        @media (max-width: 640px) {
            ul.notifications {
                left: 12px;
                right: 12px;
                top: 70px;
            }
        }
    </style>

    {{-- Toast container --}}
    <ul class="notifications"></ul>

    <div class="container mx-auto px-4 py-6">
        <div class="wraplogin">
            <div class="actionsedit">
                <a href="{{ route('profile') }}" class="btn">แก้ไขข้อมูลส่วนตัว</a>
                <a href="{{ route('HistoryBooking') }}" class="btn allhistory">ดูประวัติการจอง</a>
                @if (Auth::user()->admin == true)
                    <a href="{{ route('historyadmin') }}" class="btn allhistory">การจองทั้งหมด</a>
                @endif
            </div>

            <div class="profile-content">
                {{-- Card 1: ข้อมูลส่วนตัว --}}
                <div class="card">
                    <div class="cardProfile-img">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="avatar" class="user-avatar">
                    </div>
                    <h2>แก้ไขข้อมูลส่วนตัว</h2>
                    @livewire('profile.update-profile-information-form')
                </div>

                {{-- Card 2: เปลี่ยนรหัสผ่าน --}}
                <div class="card">
                    <h2>เปลี่ยนรหัสผ่าน</h2>
                    @livewire('profile.update-password-form')
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Toast helpers ===== --}}
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
            warning: {
                icon: 'fa-triangle-exclamation',
                defaultText: 'กรุณาตรวจสอบข้อมูล'
            },
            info: {
                icon: 'fa-circle-info',
                defaultText: 'ข้อมูลเพิ่มเติม'
            },
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
        let lastToastKey = null,
            dedupeTimer = null;
        const createToastOnce = (id, text = null, duration = 5000) => {
            const key = `${id}|${text ?? ''}`;
            if (lastToastKey === key) return;
            lastToastKey = key;
            clearTimeout(dedupeTimer);
            dedupeTimer = setTimeout(() => {
                lastToastKey = null;
            }, 800);
            createToast(id, text, duration);
        };
    </script>

    <script>
        const CURRENT_NAME = @json(Auth::user()->name);

        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.matches('form[wire\\:submit\\.prevent="updateProfileInformation"]')) {
                const nameInput = form.querySelector('#name');
                const newName = (nameInput?.value || '').trim();
                const oldName = (CURRENT_NAME || '').trim();
                if (newName === oldName) {
                    e.preventDefault();
                    e.stopPropagation();
                    createToastOnce('warning', 'ชื่อผู้ใช้เหมือนเดิม ไม่มีการเปลี่ยนแปลง', 5000);
                }
            }
        }, true);

        document.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'saveBtn') {
                const nameEl = document.getElementById('name');
                const newName = (nameEl?.value || '').trim();
                const oldName = (CURRENT_NAME || '').trim();
                if (newName === oldName) {
                    e.preventDefault();
                    e.stopPropagation();
                    createToastOnce('warning', 'ชื่อผู้ใช้เหมือนเดิม ไม่มีการเปลี่ยนแปลง', 5000);
                }
            }
        }, true);

        document.addEventListener('livewire:init', () => {
            if (window.Livewire?.on) {
                Livewire.on('saved', () => createToastOnce('success', 'บันทึกข้อมูลเรียบร้อย', 4000));
            }
            if (window.Livewire?.hook) {
                Livewire.hook('message.processed', (message, component) => {
                    const errors = (component.serverMemo && component.serverMemo.errors) ? component
                        .serverMemo.errors : {};
                    if (Object.keys(errors).length > 0) {
                        const first = Object.values(errors)[0]?.[0] ?? 'บันทึกไม่สำเร็จ';
                        createToastOnce('error', first, 6000);
                    }
                });
            }
        });
    </script>
@endsection
