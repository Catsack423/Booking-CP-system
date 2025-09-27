@extends('layouts.app')

@if (session('status'))
    <div class="p-3 bg-green-100 text-green-800 rounded mb-3">
        {{ session('status') }}
    </div>
@endif
<link rel="stylesheet" href="{{ asset('css/Booking.css') }}">

@if ($errors->any())
    <div class="p-3 bg-red-100 text-red-800 rounded mb-3">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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

<script>
    function checkphone() {
        let phone = document.getElementById("phone");
        let phondanger = document.getElementById("phone-danger");
        if (phone.value.length != 10) {
            phondanger.style.visibility = "visible"
            phone.style.borderColor = "red";
            phone.style.borderWidth = "1px";
            e.preventDefault();
            return;
        }else{
            phondanger.style.visibility = "hidden"
            phone.style.borderColor = "";
            phone.style.borderWidth = "0px";
        }
    }

    function checkname(){
      let fname = document.getElementById("fname");
      let fnamedanger = document.getElementById("firstname-danger");
      let lname = document.getElementById("lname");
      let lnamedanger = document.getElementById("lastname-danger");

      if (fname.value.trim().length <=0) {
        fnamedanger.style.visibility = "visible"
        fname.style.borderColor = "red";
        fname.style.borderWidth = "1px";
        
      }else{
        fnamedanger.style.visibility = "hidden"
        fname.style.borderColor = "";
        fname.style.borderWidth = "0px";
      }

      if (lname.value.trim().length <=0) {
        lnamedanger.style.visibility = "visible"
        lname.style.borderColor = "red";
        lname.style.borderWidth = "1px";
        
      }else{
        lnamedanger.style.visibility = "hidden"
        lname.style.borderColor = "";
        lname.style.borderWidth = "0px";
      }
    }

    function checkslot() {
        let slots = document.querySelectorAll("input[name='slots[]']:checked");
        if (slots.length === 0) {
            alert("กรุณาเลือกช่วงเวลาอย่างน้อย 1 ช่อง");
            e.preventDefault();
            return;
        }
    }

    function checkdetail() {
        let detail = document.getElementById("detail");
        let areadanger = document.getElementById("textarea-danger");
        if (detail.value.length == 0) {
            areadanger.style.visibility = "visible"
            detail.style.borderColor = "red";
            detail.style.borderWidth = "1px";
            e.preventDefault();
            return;
        }else{
            areadanger.style.visibility = "hidden"
            detail.style.borderColor = "";
            detail.style.borderWidth = "0px";
        }
    }

    function validate() {
        checkphone()
        checkslot()
        checkdetail()
        checkname()
    }
</script>
@section('title', 'Booking')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">

@section('content')
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
            <div style="display:flex; gap:12px; margin-bottom:12px">
                <div style="flex:1">
                    <div class="bk-lbl">Name <b id="firstname-danger" class="danger">***กรุณากรอกข้อมูล</b></div>
                    <input class="bk-input" name="first_name" placeholder="Name" id="fname" value="{{ old('first_name') }}"  onblur="checkname()">
                </div>

                <div style="flex:1">
                    <div class="bk-lbl">Last Name<b id="lastname-danger" class="danger">***กรุณากรอกข้อมูล</b></div>
                    <input class="bk-input" name="last_name" placeholder="Last Name" id="lname" value="{{ old('last_name') }}" onblur="checkname()" required>
                </div>
                <div style="flex:1">
                    <div class="bk-lbl">Phone <b id="phone-danger" class="danger">***กรุณากรอกเบอร์โทรให้ครบ 10 หลัก</b></div>
                    <input class="bk-input" name="phone" id="phone" placeholder="Phone" value="{{ old('phone') }}"
                        inputmode="numeric" onblur="checkphone()" maxlength="10" required type="number">
                </div>
            </div>

            <div>
                <div class="bk-lbl">Detail <b id="textarea-danger" class="danger"> ***กรุณากรอกข้อมูล </b></div>
                <textarea name="detail" id="detail" cols="30" rows="10" placeholder="Detail" value="{{ old('detail') }}"
                    onblur="checkdetail()"></textarea>
                
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
                            $s = $slotStatus[$t] ?? ['status' => 'free', 'label' => 'ว่าง', 'class' => 'bg-free'];
                        @endphp

                        <label class="bk-cell {{ $s['class'] }}" title="{{ $s['label'] }}">
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
                <button type="submit" class="btn-book " onclick="validate()">จอง</button>
            </div>
        </form>
    </div>
@endsection
