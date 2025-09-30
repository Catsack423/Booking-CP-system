@extends('layouts.app')

@section('title', 'HistoryAdmin')
@section('hideFooter', true)

@php
    $dayVal = $date ?? now()->toDateString();
@endphp

@section('content')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/historyadmin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        /* กัน navbar fixed */
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: "Noto Sans Thai UI", sans-serif;
            background: #f5f5f5;
        }

        body {
            padding-top: 90px;
        }

        @media (max-width:832px) {
            body {
                padding-top: 64px;
            }
        }

        /* Toast ต่ำกว่า navbar */
        ul.notifications {
            position: fixed;
            top: 80px;
            right: 16px;
            z-index: 2300;
        }

        @media (max-width:640px) {
            ul.notifications {
                left: 12px;
                right: 12px;
                top: 70px;
            }
        }

        /* เผื่อกรณี class .modal.show ใช้ display:flex */
        .modal.show {
            display: flex;
        }
    </style>

    <ul class="notifications"></ul>

    <div class="wrap">
        <div class="actions">
            <a href="{{ route('profile') }}" class="btn-profile">แก้ไขข้อมูลส่วนตัว</a>
            <a href="{{ route('HistoryBooking') }}" class="btn-profile">ดูประวัติการจอง</a>
            @if (Auth::user()->admin == true)
                <a href="{{ route('historyadmin') }}" class="btn allhistory">การจองทั้งหมด</a>
            @endif
        </div>

        <div class="filters">
            <input type="text" id="searchbar" class="searchbar" placeholder="ค้นหาข้อมูล">
            <input type="date" id="datebar" class="datebar">
        </div>

        <div class="table-wrap">
            <table id="searchtable">
                <thead>
                    <tr>
                        <th>ชื่อคนจอง</th>
                        <th>ห้อง</th>
                        <th>ช่วงเวลาที่จอง</th>
                        <th>วันที่จอง</th>
                        <th>จัดการ</th>
                        <th>คำร้องขอ</th>
                        <th>จองเมื่อ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $r)
                        <tr>
                            <td data-th="ชื่อคนจอง">{{ $r['user'] }}</td>
                            <td data-th="ห้อง">{{ $r['room'] }}</td>
                            <td data-th="ช่วงเวลาที่จอง">
                                @foreach ($r['slots'] as $slot)
                                    <p>{{ $slot }}</p>
                                @endforeach
                            </td>
                            <td data-th="วันที่จอง">{{ $r['day'] }}</td>

                            <td data-th="จัดการ" class="cell-actions">
                                <button type="button" class="btn-open" onclick="openEditModal(this)"
                                    data-id="{{ $r['id'] }}" data-room-id="{{ $r['room'] }}"
                                    data-room-code="{{ $r['room'] }}" data-day="{{ $r['day_iso'] }}"
                                    data-first-name="{{ $r['first_name'] ?? '' }}"
                                    data-last-name="{{ $r['last_name'] ?? '' }}" data-phone="{{ $r['phone'] ?? '' }}"
                                    data-detail="{{ $r['detail'] ?? '' }}">
                                    แก้ไข
                                </button>
                            </td>

                            <td data-th="คำร้องขอ" class="cell-approve">
                                @if ($r['status'] === 'approved')
                                    <span class="status-approve">อนุมัติแล้ว</span>
                                @elseif ($r['status'] === 'rejected')
                                    <span class="status-reject">ปฏิเสธแล้ว</span>
                                @else
                                    <form action="{{ route('historyadmin.approve', $r['id']) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="btn-approve">อนุมัติ</button>
                                    </form>
                                    <form action="{{ route('historyadmin.reject', $r['id']) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="btn-reject">ปฏิเสธ</button>
                                    </form>
                                @endif
                            </td>

                            <td data-th="จองเมื่อ">{{ $r['created_at'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;">ยังไม่มีรายการจอง</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h1 id="notfoundtext">ไม่พบข้อมูล</h1>
    </div>

    {{-- Modal --}}
    <div id="editModal" class="modal" aria-hidden="true">
        <div class="modal__panel" role="dialog" aria-modal="true" aria-labelledby="editTitle">
            <div class="modal__head">
                <div id="editTitle" class="modal__title">แก้ไข</div>
                <button type="button" class="modal__close" aria-label="ปิด" onclick="closeEditModal()">×</button>
            </div>

            <form id="editForm" method="POST" class="modal__body">
                @csrf
                <input type="hidden" id="m_id" name="id">
                <input type="hidden" id="m_room_id" name="room_id">
                <input type="hidden" id="m_day" name="day" value="{{ $dayVal }}">

                <label class="field">
                    <span class="field__label">Room</span>
                    <input id="m_room_code" class="field__input" disabled>
                </label>

                <div class="grid-2">
                    <label class="field">
                        <span class="field__label">Name</span>
                        <input id="m_first_name" name="first_name" class="field__input" placeholder="Name">
                    </label>
                    <label class="field">
                        <span class="field__label">LastName</span>
                        <input id="m_last_name" name="last_name" class="field__input" placeholder="LastName">
                    </label>
                </div>

                <label class="field">
                    <span class="field__label">Phone</span>
                    <input id="m_phone" name="phone" class="field__input" placeholder="Phone" inputmode="numeric"
                        maxlength="10">
                </label>

                <label class="field">
                    <span class="field__label">Detail</span>
                    <textarea id="m_detail" name="detail" class="field__input field__textarea" placeholder="Detail"></textarea>
                </label>
            </form>

            <div class="modal__footer">
                <form id="deleteForm" method="POST" onsubmit="return confirm('คุณต้องการลบการจองนี้หรือไม่?');"
                    style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">ลบการจอง</button>
                </form>
                <button type="submit" form="editForm" class="btn-primary">บันทึก</button>
            </div>
        </div>
    </div>

    {{-- JS --}}
    <script>
        const updateUrlTemplate = "{{ url('/historyadmin') }}/__ID__/update";
        const deleteUrlTemplate = "{{ url('/historyadmin') }}/__ID__";

        function openEditModal(btn) {
            const d = btn.dataset;
            document.getElementById('editForm').action = updateUrlTemplate.replace('__ID__', d.id);
            document.getElementById('deleteForm').action = deleteUrlTemplate.replace('__ID__', d.id);

            m_id.value = d.id || '';
            m_room_id.value = d.roomId || '';
            m_room_code.value = d.roomCode || '';
            m_day.value = d.day || '';
            m_first_name.value = d.firstName || '';
            m_last_name.value = d.lastName || '';
            m_phone.value = d.phone || '';
            m_detail.value = d.detail || '';

            const modal = document.getElementById('editModal');
            modal.classList.add('show');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('show');
        }
        document.addEventListener('click', e => {
            if (e.target === editModal) closeEditModal();
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeEditModal();
        });

        // Toast
        const notifications = document.querySelector(".notifications");
        const toastDetails = {
            success: {
                icon: 'fa-circle-check',
                defaultText: 'ดำเนินการสำเร็จ'
            },
            error: {
                icon: 'fa-circle-xmark',
                defaultText: 'เกิดข้อผิดพลาด'
            },
        };
        const removeToast = (t) => {
            t.classList.add("hide");
            if (t.timeoutId) clearTimeout(t.timeoutId);
            setTimeout(() => t.remove(), 500);
        };
        const createToast = (id, txt = null, duration = 4500) => {
            const c = toastDetails[id] || toastDetails.error;
            const toast = document.createElement("li");
            toast.className = `toast ${id}`;
            toast.style.setProperty('--timer', duration + 'ms');
            toast.innerHTML = `
          <div class="column"><i class="fa-solid ${c.icon}"></i><span>${(txt ?? c.defaultText).toString().replace(/\n/g,'<br>')}</span></div>
          <i class="fa-solid fa-xmark" aria-label="Close"></i>`;
            notifications.appendChild(toast);
            toast.querySelector(".fa-xmark").addEventListener("click", () => removeToast(toast));
            toast.timeoutId = setTimeout(() => removeToast(toast), duration);
        };

        @if (session('success'))
            createToast('success', @json(session('success')), 4000);
        @endif
        @if (session('error'))
            createToast('error', @json(session('error')), 6000);
        @endif
        @if ($errors->any())
            createToast('error', {!! json_encode(implode("\n", $errors->all())) !!}, 7000);
        @endif
    </script>

    <script src="{{ asset('javascript/tableserach.js') }}"></script>
@endsection
