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
            foreach ($requests as $r) {
                if ((int) $r->{$col} === 1 && (int) $r->reject_status === 0) {
                    if ((int) $r->approve_status === 1) {
                        $state = 'approved';
                        break;
                    } elseif ((int) $r->wait_status === 1) {
                        $state = 'pending';
                    }
                }
            }
            $slotStatus[$time] = match ($state) {
                'approved' => ['status' => 'approved', 'label' => 'เต็มแล้ว', 'class' => 'bg-full'],
                'pending' => ['status' => 'pending', 'label' => 'รออนุมัติ', 'class' => 'bg-pending'],
                default => ['status' => 'free', 'label' => 'ว่าง', 'class' => 'bg-free'],
            };
        }
    }
@endphp

@section('title', 'Booking')

@section('content')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/Booking.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    {{-- Icons สำหรับ toast --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        /* === Layout ฟอร์ม 3→2→1 คอลัมน์ === */
        .bk-wrap {
            max-width: 980px;
            margin-inline: auto;
            padding: clamp(12px, 2vw, 24px);
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

        /* === แถบหัววันที่ === */
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

        /* === ตารางเวลา === */
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
        }

        .bk-status>.bk-cell:last-child {
            border-right: 0;
        }

        .bk-chip {
            font-size: 0.9rem;
        }

        /* === เวลาในช่อง: ซ่อนไว้บนจอใหญ่ (ใช้หัวตาราง) === */
        .bk-time {
            display: none;
        }

        /* แท็บเล็ต */
        @media (max-width: 900px) {
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

            /* โชว์เวลาที่มุมบนซ้ายของแต่ละช่องแทนหัวตาราง */
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
                font-size: 0.85rem;
            }
        }

        /* มือถือแนวตั้ง */
        @media (max-width: 560px) {
            .bk-row {
                grid-template-columns: 1fr;
            }

            .bk-input {
                height: 46px;
            }

            /* แตะง่ายขึ้น */
        }

        @media (max-width: 480px) {
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

            /* กัน iOS ซูม */
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
                        @php $s = $slotStatus[$t] ?? ['status'=>'free','label'=>'ว่าง','class'=>'bg-free']; @endphp
                        <label class="bk-cell {{ $s['class'] }}" title="{{ $s['label'] }}">
                            <span class="bk-time">{{ $fmt($t) }}</span>

                            <span class="bk-chip">{{ $s['label'] }}</span>
                            @if ($s['status'] === 'free')
                                <input type="checkbox" class="bk-check" name="slots[]" value="{{ $t }}"
                                    {{ in_array($t, (array) old('slots', [])) ? 'checked' : '' }}>
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

    <script>
        // ---------- Toast helpers ----------
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
        const createToast = (id, text = null, duration = 5000) => {
            const conf = toastDetails[id] || toastDetails.info;
            const toast = document.createElement("li");
            toast.className = `toast ${id}`;
            toast.style.setProperty('--timer', duration + 'ms');
            toast.innerHTML = `
          <div class="column"><i class="fa-solid ${conf.icon}"></i><span>${(text ?? conf.defaultText).toString().replace(/\n/g,'<br>')}</span></div>
          <i class="fa-solid fa-xmark" aria-label="Close"></i>`;
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

        // ---------- Validate ฝั่ง client ----------
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
            const selectedSlots = document.querySelectorAll("input[name='slots[]']:checked").length;
            if (selectedSlots === 0) errs.push('กรุณาเลือกช่วงเวลาอย่างน้อย 1 ช่อง');
            return errs;
        };

        form.addEventListener('submit', (e) => {
            const errs = validateClient();
            if (errs.length > 0) {
                e.preventDefault();
                createToastOnce('error', errs.join('\n'), 7000);
            }
        });

        @if (session('status'))
            createToastOnce('success', @json(session('status')), 4000);
        @endif
        @if ($errors->any())
            createToastOnce('error', {!! json_encode(implode("\n", $errors->all())) !!}, 7000);
        @endif
    </script>
@endsection
