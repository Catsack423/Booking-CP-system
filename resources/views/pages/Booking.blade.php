@extends('layouts.app')

@php
    use Illuminate\Support\Carbon;
    $room = $room ?? ($rooms->first() ?? null);
    $roomId = $room->id ?? ($rooms->first()->id ?? 1);
    $roomCode = $room->room_id ?? ($rooms->first()->id ?? '');
    $dayVal = $date ?? now()->toDateString();

    $timeToCol = [
        '08:00-09:00' => '8_9_slot',
        '09:00-10:00' => '9_10_slot',
        '10:00-11:00' => '10_11_slot',
        '11:00-12:00' => '11_12_slot',
        '12:00-13:00' => '12_13_slot',
        '13:00-14:00' => '13_14_slot',
        '14:00-15:00' => '14_15_slot',
        '15:00-16:00' => '15_16_slot',
        '16:00-17:00' => '16_17_slot',
        '17:00-18:00' => '17_18_slot',
        '18:00-19:00' => '18_19_slot',
    ];
    $timeLabels = array_keys($timeToCol);
    $fmt = fn($t) => str_replace(':', '.', $t);

    if (!isset($slotStatus)) {
        $slotStatus = [];
        $requests = \App\Models\Request::where('room_id', $roomId)
            ->whereDate('day', Carbon::parse($dayVal)->toDateString())
            ->get([
                'id',
                'user_id',
                'room_id',
                'day',
                'first_name',
                'last_name',
                'phone',
                'detail',
                'wait_status',
                'approve_status',
                'reject_status',
                '8_9_slot',
                '9_10_slot',
                '10_11_slot',
                '11_12_slot',
                '12_13_slot',
                '13_14_slot',
                '14_15_slot',
                '15_16_slot',
                '16_17_slot',
                '17_18_slot',
                '18_19_slot',
            ]);

        foreach ($timeToCol as $time => $col) {
            $state = 'free';
            $related = collect();
            foreach ($requests as $r) {
                if ((int) $r->{$col} === 1 && (int) $r->reject_status === 0) {
                    $related->push($r);
                    if ((int) $r->approve_status === 1) {
                        $state = 'approved';
                        break;
                    } elseif ((int) $r->wait_status === 1) {
                        $state = 'pending';
                    }
                }
            }
            $slotStatus[$time] = match ($state) {
                'approved' => [
                    'status' => 'approved',
                    'label' => 'เต็มแล้ว',
                    'class' => 'bg-full',
                    'requests' => $related,
                ],
                'pending' => [
                    'status' => 'pending',
                    'label' => 'รออนุมัติ',
                    'class' => 'bg-pending',
                    'requests' => $related,
                ],
                default => ['status' => 'free', 'label' => 'ว่าง', 'class' => 'bg-free', 'requests' => collect()],
            };
        }
    }
@endphp

@section('title', 'Booking')

@section('content')
    {{-- styles --}}
    <link rel="stylesheet" href="{{ asset('css/Booking.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        html,
        body {
            margin-top: -15%;
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: "Noto Sans Thai UI", sans-serif;
        }

        .bk-wrap {
            max-width: 980px;
            margin-inline: auto;
            padding: clamp(12px, 2vw, 24px);
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .1);
        }

        .bk-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 12px;
        }

        .bk-field {
            display: flex;
            flex-direction: column;
        }

        .bk-lbl {
            font-size: 14px;
            color: #374151;
            margin-bottom: 6px;
            line-height: 1.2;
        }

        .bk-input {
            width: 100%;
            height: 44px;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #fff;
            box-sizing: border-box;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
        }

        .danger {
            visibility: hidden;
            color: #e24d4c;
            font-weight: 500;
            margin-left: 6px;
        }

        .has-error {
            border-color: #e24d4c !important;
        }

        .bk-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .bk-btn {
            padding: 8px 14px;
        }

        .bk-table {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .bk-table .bk-head {
            display: grid;
            grid-template-columns: repeat(11, minmax(0, 1fr));
            gap: 0;
            margin-bottom: 0;
        }

        .bk-table .bk-head>div {
            padding: 10px 8px;
            text-align: center;
            background: #f3f4f6;
            font-weight: 700;
            border-right: 1px solid #e5e7eb;
        }

        .bk-table .bk-head>div:last-child {
            border-right: 0;
        }

        .bk-status {
            display: grid;
            grid-template-columns: repeat(11, minmax(0, 1fr));
            gap: 0;
        }

        .bk-cell {
            min-height: 56px;
            position: relative;
            border-top: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bk-status>.bk-cell:last-child {
            border-right: 0;
        }

        .bk-chip {
            font-size: .9rem;
        }

        .bk-time {
            display: none;
        }

        .bk-cell .btn-edit {
            position: absolute;
            bottom: 6px;
            right: 6px;
            appearance: none;
            border: 0;
            border-radius: 8px;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 400;
            color: #111;
            cursor: pointer;
        }

        .bk-cell .btn-edit:hover {
            filter: brightness(1.05);
        }

        /* Tablet */
        @media (max-width:900px) {
            .bk-row {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .bk-table .bk-head {
                display: none;
            }

            /* ซ่อนหัวตาราง */
            .bk-status {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }

            .bk-status .bk-cell {
                padding-top: 32px;
            }

            .bk-status .bk-cell .bk-time {
                display: inline-block;
                position: absolute;
                top: 6px;
                left: 8px;
                font-weight: 700;
                font-size: 12px;
                color: #111827;
                background: rgba(255, 255, 255, .9);
                border: 1px solid #e5e7eb;
                border-radius: 6px;
                padding: 2px 6px;
                line-height: 1;
            }

            .bk-chip {
                display: none !important;
            }

        }

        @media (max-width:560px) {
            .bk-row {
                grid-template-columns: 1fr;
            }

            .bk-input {
                height: 46px;
            }
        }

        @media (max-width:480px) {
            .bk-topbar .bk-title {
                width: 100%;
                text-align: center;
                order: -1;
                margin: 6px 0;
            }

            .bk-btn {
                padding: 8px 10px;
                font-size: 14px;
            }

            .bk-status {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .bk-status .bk-cell {
                padding-top: 34px;
            }

            .bk-status .bk-cell .bk-time {
                font-size: 13px;
                top: 7px;
                left: 8px;
            }

            .bk-input,
            textarea {
                font-size: 16px;
            }
        }
    </style>

    {{-- Toast container --}}
    <ul class="notifications"></ul>

    <div class="bk-wrap">
        <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
            @csrf
            <input type="hidden" name="room_id" value="{{ $roomId }}">
            <input type="hidden" name="day" value="{{ $dayVal }}">
            <input type="hidden" name="floor" value="{{ $floor }}">

            <div>
                <div class="bk-lbl">Room</div>
                <input class="bk-input" value="{{ $roomCode }}" disabled>
            </div>

            <div class="bk-row">
                <div class="bk-field">
                    <div class="bk-lbl">Name <b id="firstname-danger" class="danger">***กรุณากรอกข้อมูล</b></div>
                    <input class="bk-input" name="first_name" id="fname" placeholder="Name"
                        value="{{ old('first_name') }}">
                </div>
                <div class="bk-field">
                    <div class="bk-lbl">Last Name <b id="lastname-danger" class="danger">***กรุณากรอกข้อมูล</b></div>
                    <input class="bk-input" name="last_name" id="lname" placeholder="Last Name"
                        value="{{ old('last_name') }}">
                </div>
                <div class="bk-field">
                    <div class="bk-lbl">Phone <b id="phone-danger" class="danger">***กรุณากรอกเบอร์โทรให้ครบ 10 หลัก</b>
                    </div>
                    <input class="bk-input" name="phone" id="phone" placeholder="Phone" value="{{ old('phone') }}"
                        inputmode="numeric" maxlength="10" pattern="[0-9]{10}">
                </div>
            </div>

            <div>
                <div class="bk-lbl">Detail <b id="textarea-danger" class="danger">***กรุณากรอกข้อมูล</b></div>
                <textarea name="detail" id="detail" cols="30" rows="8" placeholder="Detail">{{ old('detail') }}</textarea>
            </div>

            <div class="bk-topbar">
                <a href="{{ route('booking.index', ['floor' => $floor, 'room' => $room->id]) }}?date={{ \Carbon\Carbon::parse($dayVal)->subDay()->toDateString() }}"
                    class="bk-btn">
                    < เมื่อวาน</a>
                        <div class="bk-title">📅 {{ \Carbon\Carbon::parse($dayVal)->format('d/m/Y') }}</div>
                        <a href="{{ route('booking.index', ['floor' => $floor, 'room' => $room->id]) }}?date={{ \Carbon\Carbon::parse($dayVal)->addDay()->toDateString() }}"
                            class="bk-btn">วันถัดไป ></a>
            </div>

            <div class="bk-table">
                <div class="bk-head">
                    @foreach ($timeLabels as $t)
                        <div>{{ $fmt($t) }}</div>
                    @endforeach
                </div>

                <div class="bk-status">
                    @foreach ($timeLabels as $t)
                       
                        @php 
                            $s = $slotStatus[$t] ?? ['status'=>'free','label'=>'ว่าง','class'=>'bg-free','requests'=>collect()]; 
                            $r = $s['requests']->first(); 
                        @endphp
                        <label class="bk-cell {{ $s['class'] }}" title="{{ $s['label'] }}">
                            <span class="bk-time">{{ $fmt($t) }}</span>
                            @if ($r && $r->user_id != Auth::user()->id && $s['status']=="pending")
                                <span class="bk-chip">ผู้ใช้อื่นกำลังรออนุมัติ</span>  
                            @else
                                <span class="bk-chip">{{ $s['label'] }}</span>
                            @endif
                            

                            @if ($s['status'] === 'free')
                                <input type="checkbox" class="bk-check" name="slots[]" value="{{ $t }}"
                                    {{ in_array($t, (array) old('slots', [])) ? 'checked' : '' }}>
                            @else
                                
                                @if ($s['status'] === 'approved' && $r && $r->user_id == Auth::user()->id)
                                    <button type="button" class="btn-edit" onclick="openEditModal(this)"
                                        data-id="{{ $r->id }}" data-room-id="{{ $r->room_id ?? $roomId }}"
                                        data-room-code="{{ $r->room_code ?? $roomCode }}" data-day="{{ $r->day }}"
                                        data-first-name="{{ $r->first_name ?? '' }}"
                                        data-last-name="{{ $r->last_name ?? '' }}" data-phone="{{ $r->phone ?? '' }}"
                                        data-detail="{{ $r->detail ?? '' }}">
                                        แก้ไข
                                    </button>
                                @endif
                            @endif
                        </label>
                    @endforeach
                </div>
            </div>

            <br><br>
            <div class="flex-btns">
                <button type="button" class="btn-cancel"
                    onclick="window.location.href='{{ route('floor' . $floor) }}'">ยกเลิก</button>
                <button type="submit" class="btn-book">จอง</button>
            </div>
        </form>
    </div>

    {{-- Modal แก้ไข --}}
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
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-delete">ลบการจอง</button>
                </form>
                <button type="submit" form="editForm" class="btn-save">บันทึก</button>
            </div>
        </div>
    </div>

    <script>
        /* ===== Modal ===== */
        const updateUrlTemplate = "{{ url('/historyadmin') }}/__ID__/update";
        const deleteUrlTemplate = "{{ url('/historyadmin') }}/__ID__";

        function openEditModal(btn) {
            const d = btn.dataset;
            document.getElementById('editForm').action = updateUrlTemplate.replace('__ID__', d.id);
            document.getElementById('deleteForm').action = deleteUrlTemplate.replace('__ID__', d.id);

            document.getElementById('m_id').value = d.id || '';
            document.getElementById('m_room_id').value = d.roomId || '';
            document.getElementById('m_room_code').value = d.roomCode || d.roomId || '';
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
            if (e.target === document.getElementById('editModal')) closeEditModal();
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeEditModal();
        });

        /* ===== Toast helpers (ใช้คู่กับ public/css/toast.css ของคุณ) ===== */
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
            warning: {
                icon: 'fa-triangle-exclamation',
                defaultText: 'กรุณาตรวจสอบข้อมูล'
            },
            info: {
                icon: 'fa-circle-info',
                defaultText: 'ข้อมูล'
            },
        };
        const removeToast = (toast) => {
            toast.classList.add("hide");
            if (toast.timeoutId) clearTimeout(toast.timeoutId);
            setTimeout(() => toast.remove(), 500);
        };

        function createToast(id, text = null, duration = 5000) {
            const conf = toastDetails[id] || toastDetails.info;
            const toast = document.createElement("li");
            toast.className = `toast ${id}`;
            toast.style.setProperty('--timer', duration + 'ms'); // ใช้ progress bar ใน CSS ที่ตั้งไว้
            toast.innerHTML = `
          <div class="column">
            <i class="fa-solid ${conf.icon}"></i>
            <span>${(text ?? conf.defaultText).toString().replace(/\n/g,'<br>')}</span>
          </div>
          <i class="fa-solid fa-xmark" aria-label="Close"></i>`;
            notifications.appendChild(toast);
            toast.querySelector(".fa-xmark").addEventListener("click", () => removeToast(toast));
            toast.timeoutId = setTimeout(() => removeToast(toast), duration);
        }
        let lastToastKey = null,
            dedupeTimer = null;

        function createToastOnce(id, text = null, duration = 5000) {
            const key = `${id}|${text ?? ''}`;
            if (lastToastKey === key) return;
            lastToastKey = key;
            clearTimeout(dedupeTimer);
            dedupeTimer = setTimeout(() => {
                lastToastKey = null;
            }, 800);
            createToast(id, text, duration);
        }

        /* ===== Validate ฝั่ง client ===== */
        const form = document.getElementById('bookingForm');
        const fname = document.getElementById('fname');
        const lname = document.getElementById('lname');
        const phone = document.getElementById('phone');
        const detail = document.getElementById('detail');

        const mark = (el, ok, warnId) => {
            const warn = document.getElementById(warnId);
            if (ok) {
                el.classList.remove('has-error');
                if (warn) warn.style.visibility = 'hidden';
            } else {
                el.classList.add('has-error');
                if (warn) warn.style.visibility = 'visible';
            }
        };

        const validateClient = () => {
            const errs = [];
            const fok = (fname.value ?? '').trim().length > 0;
            mark(fname, fok, 'firstname-danger');
            if (!fok) errs.push('กรุณากรอกชื่อ');
            const lok = (lname.value ?? '').trim().length > 0;
            mark(lname, lok, 'lastname-danger');
            if (!lok) errs.push('กรุณากรอกนามสกุล');
            const pok = /^[0-9]{10}$/.test((phone.value ?? '').trim());
            mark(phone, pok, 'phone-danger');
            if (!pok) errs.push('กรุณากรอกเบอร์โทรให้ครบ 10 หลัก');
            const dok = (detail.value ?? '').trim().length > 0;
            mark(detail, dok, 'textarea-danger');
            if (!dok) errs.push('กรุณากรอกรายละเอียด');
            const selected = document.querySelectorAll("input[name='slots[]']:checked").length;
            if (selected === 0) errs.push('กรุณาเลือกช่วงเวลาอย่างน้อย 1 ช่อง');
            return errs;
        };

        form.addEventListener('submit', (e) => {
            const errs = validateClient();
            if (errs.length > 0) {
                e.preventDefault();
                createToastOnce('error', errs.join('\n'), 7000);
            } else {
                createToastOnce('info', 'กำลังส่งคำขอจอง...');
            }
        });

        /* ===== Flash from Laravel ===== */
        @if (session('status'))
            createToastOnce('success', @json(session('status')), 4000);
        @endif
        @if (session('success'))
            createToastOnce('success', @json(session('success')), 4000);
        @endif
        @if (session('error'))
            createToastOnce('error', @json(session('error')), 6000);
        @endif
        @if (session('warning'))
            createToastOnce('warning', @json(session('warning')), 6000);
        @endif
        @if (session('info'))
            createToastOnce('info', @json(session('info')), 5000);
        @endif
        @if ($errors->any())
            createToastOnce('error', {!! json_encode(implode("\n", $errors->all())) !!}, 7000);
        @endif
    </script>
@endsection
