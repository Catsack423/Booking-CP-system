@extends('layouts.app')

@php
    $dayVal = $date ?? now()->toDateString();
@endphp

@section('content')
    <link rel="stylesheet" href="{{ asset('css/historyadmin.css') }}">
    <style>
        html,
        body {
            margin: 4%;
            padding: 0;
            height: 100%;
            font-family: "Noto Sans Thai UI", sans-serif;
        }

        .modal.show {
            display: flex;
        }

        /* ต้องมีเพื่อให้เห็น modal เมื่อ add class show */
    </style>

    <div class="wrap">
        <div class="actions">
            <a href="{{ route('profile') }}" class="btn-profile">แก้ไขข้อมูลส่วนตัว</a>
            <a href="{{ route('HistoryBooking') }}" class="btn btn-primary">ดูประวัติการจอง</a>
            @if (Auth::user()->admin == true)
                <a href="{{ route('historyadmin') }}" class="btn allhistory">การจองทั้งหมด</a>
            @endif
        </div>
        <div>
            <input type="text" id="searchbar" class="searchbar" placeholder="ค้นหาข้อมูล">
            <input type="date" name="" id="datebar" class="datebar">
            <div>
                <table id="searchtable">
                    <thead>

                        <th>ชื่อคนจอง</th>
                        <th>ห้อง</th>
                        <th>ช่วงเวลาที่จอง</th>

                        <th>วันที่จอง</th>
                        <th>จัดการ</th>
                        <th>คำร้องขอ</th>
                        <th>จองเมื่อ</th>

                    </thead>
                    <tbody>
                        @forelse($rows as $r)
                            <tr>
                                <td>{{ $r['user'] }}</td>
                                <td>{{ $r['room'] }}</td>
                                <td>
                                    @foreach ($r['slots'] as $slot)
                                        <p>{{ $slot }} </p>
                                    @endforeach
                                </td>
                                <td>{{ $r['day'] }}</td>
                                <td>
                                    <button type="button" class="btn-open" onclick="openEditModal(this)"
                                        data-id="{{ $r['id'] }}" data-room-id="{{ $r['room'] }}"
                                        data-room-code="{{ $r['room'] }}" data-day="{{ $r['day_iso'] }}"
                                        data-first-name="{{ $r['first_name'] ?? '' }}"
                                        data-last-name="{{ $r['last_name'] ?? '' }}" data-phone="{{ $r['phone'] ?? '' }}"
                                        data-detail="{{ $r['detail'] ?? '' }}">
                                        แก้ไข
                                    </button>
                                </td>

                                <td>
                                    @if ($r['status'] === 'approved')
                                        <span class="status-approve">อนุมัติแล้ว</span>
                                    @elseif($r['status'] === 'rejected')
                                        <span class="status-reject">ปฏิเสธแล้ว</span>
                                    @else
                                        <form action="{{ route('historyadmin.approve', $r['id']) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-approve">อนุมัติ</button>
                                        </form>
                                        <form action="{{ route('historyadmin.reject', $r['id']) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-reject">ปฏิเสธ</button>
                                        </form>
                                    @endif
                                </td>
                                <td>{{ $r['created_at'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;">ยังไม่มีรายการจอง</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <h1 id="notfoundtext">ไม่พบข้อมูล</h1>
            </div>
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

        <script>
            const updateUrlTemplate = "{{ url('/historyadmin') }}/__ID__/update";
            const deleteUrlTemplate = "{{ url('/historyadmin') }}/__ID__";

            function openEditModal(btn) {
                const d = btn.dataset;
                document.getElementById('editForm').action = updateUrlTemplate.replace('__ID__', d.id);
                document.getElementById('deleteForm').action = deleteUrlTemplate.replace('__ID__', d.id);

                document.getElementById('m_id').value = d.id || '';
                document.getElementById('m_room_id').value = d.roomId || '';
                document.getElementById('m_room_code').value = d.roomCode || '';
                document.getElementById('m_day').value = d.day || '';
                document.getElementById('m_first_name').value = d.firstName || '';
                document.getElementById('m_last_name').value = d.lastName || '';
                document.getElementById('m_phone').value = d.phone || '';
                document.getElementById('m_detail').value = d.detail || '';

                document.getElementById('editModal').style.display = 'flex';
                document.getElementById('editModal').classList.add('show');
            }

            function closeEditModal() {
                document.getElementById('editModal').style.display = 'none';
                document.getElementById('editModal').classList.remove('show');
            }
            document.addEventListener('click', e => {
                const m = document.getElementById('editModal');
                if (e.target === m) closeEditModal();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeEditModal();
            });
        </script>
        <script src="{{ asset('javascript/tableserach.js') }}"></script>
    @endsection
