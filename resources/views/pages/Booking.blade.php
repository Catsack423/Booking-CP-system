
@extends('layouts.app')
  @if (session('status'))
    <div class="p-3 bg-green-100 text-green-800 rounded mb-3">
      {{ session('status') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="p-3 bg-red-100 text-red-800 rounded mb-3">
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
<style>

    :root {
        --blue: #0B76BC;
        --green: #A6F0B5;
        --red: #F3A6A6;
        --yellow: #F8E18B;
        --line: #C9CDD2;
        --card: #F2F4F5;
    }

    .bk-wrap {
        max-width: 1150px;
        margin: 12px auto;
        padding: 0 16px;
        margin-top: 150px;
    }

    .bk-card {
        background: var(--card);
        border: 1px solid #BFC6C9;
        border-radius: 12px;
        padding: 14px
    }

    .bk-grid {
        display: grid;
        grid-template-columns: 170px 1fr 1fr 1fr;
        gap: 10px
    }

    .bk-lbl {
        font-size: 13px;
        margin-bottom: 4px;
        color: #444
    }

    .bk-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #CDD5DA;
        border-radius: 10px;
        background: #fff
    }

    .bk-input[disabled] {
        background: #e9eef2;
        color: #6b7280
    }

    .bk-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 14px 0
    }

    .bk-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 18px;
        border: 1px solid #C9CDD2;
        background: #F6F7F8;
        padding: 6px 14px
    }

    .bk-title {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px
    }

    /* ตาราง */
    /* ตารางเวลา */
    .bk-table {
        border: 1px solid var(--line);
        border-radius: 8px;
        overflow: hidden;
        margin-top: 16px
    }

    .bk-head {
        display: grid;
        grid-template-columns: repeat(12, 1fr)

    }
    .bk-wrap{max-width:1150px;margin:12px auto;padding:0 16px;margin-top: 150px;}
    .bk-card{background:var(--card);border:1px solid #BFC6C9;border-radius:12px;padding:14px}
    .bk-grid{display:grid;grid-template-columns:170px 1fr 1fr 1fr;gap:10px}
    .bk-lbl{font-size:13px;margin-bottom:4px;color:#444}
    .bk-input{width:100%;padding:10px 12px;border:1px solid #CDD5DA;border-radius:10px;background:#fff}
    .bk-input[disabled]{background:#e9eef2;color:#6b7280}


    .bk-head>div {
        background: #fff;
        border-right: 1px solid var(--line);
        padding: 8px;
        text-align: center;
        font-weight: 600
    }

    /* ตารางเวลา */

    .bk-status {
        display: grid;
        grid-template-columns: repeat(12, 1fr)
    }

    /* คอลลัมตาราง */
    .bk-cell {
        position: relative;
        border-right: 1px solid var(--line);
        border-bottom: 1px solid var(--line);
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600
    }

    /* คอลลัมตาราง */

    /* ตัวหนังสือในคอลลัมตาราง */
    .bk-chip {
        position: absolute;
        top: 6px;
        left: 10px;
        font-size: 12px
    }

    /* ตัวหนังสือในคอลลัมตาราง */
    /* ตาราง */

    /* ลบ */
    .bk-del {
        position: absolute;
        top: 26px;
        left: 10px;
        background: #C91818;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 12px
    }

    /* ลบ */

    /* ปุ่มเช็ค */
    .bk-check {
        transform: scale(1.2)
    }

    /* ปุ่มเช็ค */

    /* ช่องที่บอกว่าจองแล้ว */
    .bg-booked {
        background: var(--red)
    }

    /* ช่องที่บอกว่าจองแล้ว */

    /* ช่องที่จองได้สีเขียว */
    .bg-free {
        background: var(--green)
    }

    /* ช่องที่จองได้สีเขียว */

    /* ช่องที่รออนุมัติสีเหลือง */
    .bg-pending {
        background: var(--yellow)
    }

    /* ช่องที่รออนุมัติสีเหลือง */

    /* ช่องที่เต็มแล้วสีแดง */
    .bg-full {
        background: #f4a4a4
    }

    /* ช่องที่เต็มแล้วสีแดง */
</style>
 @php
    // กำหนดช่วงเวลาให้หัวตาราง + checkbox ให้ตรงกัน 8 ช่อง (08:00 - 15:00)
    $times = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00'];

    // กำหนดค่าห้อง/วันที่ จากตัวแปรที่ controller ส่งมา (fallback กัน null)
    $room     = $room    ?? ($rooms->first() ?? null);
    $roomId   = $room->id       ?? ($rooms->first()->id ?? 1);
    $roomCode = $room->room_id  ?? ($rooms->first()->id ?? ''); // ใช้ room_id ที่มีจริง
    $dayVal   = $date ?? now()->toDateString(); // <- ใช้ day
  @endphp
<script>
    function checkphone(){
    // เช็คเบอร์โทร ต้องมี 10 ตัว
    let phone = document.getElementById("phone").value;
    if (phone.length != 10) {
      alert("กรุณากรอกเบอร์โทรให้ครบ 10 หลัก");
      e.preventDefault(); // ยกเลิกการส่งฟอร์ม
      return;
    }
  }
    function checkslot(){
    // เช็คเวลาจอง
    let slots = document.querySelectorAll("input[name='slots[]']:checked");
    if (slots.length === 0) {
      alert("กรุณาเลือกช่วงเวลาอย่างน้อย 1 ช่อง");
      e.preventDefault();
      return;
    }
  }
  function validate(){
    checkphone()
    checkslot()
  }

</script>
@section('title', 'Booking')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">

@section('content')

    <div class="bk-wrap">
        {{-- ฟอร์มข้อมูล --}}
        <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
          @csrf
          {{-- hidden ที่ต้องส่งจริง --}}
      <input type="hidden" name="room_id" value="{{ $roomId }}">
      <input type="hidden" name="day"     value="{{ $dayVal }}">
        
        <div class="bk-card">
            <div class="bk-grid">
                <div>
                    <div class="bk-lbl">Room</div>
                    <input class="bk-input" name="room_id" value="{{ $roomCode }}" disabled>
                </div>
                <div>
                    <div class="bk-lbl">Name</div>
                    <input class="bk-input" name="first_name" placeholder="Name" value="{{ old('first_name') }}" required>
                </div>
                <div>
                    <div class="bk-lbl">Last Name</div>
                    <input class="bk-input" name="last_name"  placeholder="Last Name" value="{{ old('last_name') }}" required>
                </div>
                <div>
                    <div class="bk-lbl">Phone</div>
                    <input class="bk-input" name="phone" id="phone"  placeholder="Phone" value="{{ old('phone') }}" onblur="checkphone()" require>
                </div>
            </div>
            <div class="mt-3">
                <div class="bk-lbl">Detail</div>
                <input class="bk-input" name="detail"  placeholder="Detail" value="{{ old('detail') }}">
            </div>
        </div>

        {{-- แถบวันที่ (ยังไม่ผูกเปลี่ยนวัน) --}}
      <div class="bk-topbar">
        <button class="bk-btn" type="button">⬅ เมื่อวาน</button>
        <div class="bk-title">📅 วันนี้ ({{ \Carbon\Carbon::parse($dayVal)->format('d/m/Y') }})</div>
        <button class="bk-btn" type="button">วันนี้ ➡</button>
      </div>

      <div class="bk-table">
        <div class="bk-head">
          @foreach($times as $t)
            <div>{{ $t }}</div>
          @endforeach
        </div>

        <div class="bk-status">
          @foreach($times as $t)
            <label class="bk-cell bg-free" title="เลือกช่วงเวลา {{ $t }}">
              <span class="bk-chip">ว่าง</span>
              <input type="checkbox" class="bk-check" name="slots[]" value="{{ $t }}"
                     {{ in_array($t, (array)old('slots', [])) ? 'checked' : '' }}>
            </label>
          @endforeach
        </div>
      </div>

      <div class="flex justify-end mt-3">
        <button type="submit" class="bk-btn" style="background:#0B76BC;color:#fff" onclick="validate()">บันทึกการจอง</button>
      </div>
    </form>
  </div>
  </div>
@endsection

