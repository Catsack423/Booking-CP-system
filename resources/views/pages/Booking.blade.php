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
    :root{
      --blue:#0B76BC;--green:#A6F0B5;--red:#F3A6A6;--yellow:#F8E18B;
      --line:#C9CDD2; --card:#F2F4F5;
    }
    .bk-wrap{max-width:1150px;margin:3px auto 12px;padding:0 16px;}
  .bk-card{background:var(--card);border:1px solid #BFC6C9;border-radius:12px;padding:14px}
  .bk-grid{display:grid;grid-template-columns:170px 1fr 1fr 1fr;gap:12px} /* ระยะห่างช่องกรอก */
  .bk-lbl{font-size:13px;margin-bottom:3px;color:#444;margin-top: 10px;}
  .bk-input{width:100%;padding:10px 12px;border:1px solid #CDD5DA;border-radius:10px;background:#fff;box-shadow: 0 4px 8px rgba(0,0,0,0.3); }
  .bk-input[disabled]{background:#e9eef2;color:#6b7280}
  .bk-topbar{display:flex;align-items:center;justify-content:space-between;margin:14px 0}
  .bk-btn{display:inline-flex;align-items:center;gap:6px;border-radius:18px;border:#444 ;background:#dadddfff;padding:9px 18px;box-shadow: 0 4px 8px rgba(0,0,0,0.3);}
  .bk-title{font-weight:700;display:flex;align-items:center;gap:6px;}

  .btn-book {
    margin-left: 120px;
    background: #90EE90;      /* ปุ่มจอง */
    color: #000;
    padding: 10px 24px;
    border: none;
    border-radius: 17px;
    font-size: 25px;
    font-weight: 200;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0,0,0,0.15);
    transition: 0.2s ease;
  }
  .btn-book:hover {
    background: #7bd97b;
    box-shadow: 0 6px 10px rgba(0,0,0,0.2);
  }

  .btn-cancel {
    margin-left: 350px;
    background: #f28c8c;      /* ปุ่มยกเลิก */
    color: #000;
    padding: 10px 24px;
    border: none;
    border-radius: 17px;
    font-size: 25px;  
    font-weight: 200;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0,0,0,0.15);
    transition: 0.2s ease;
  }
  .btn-cancel:hover {
    background: #e57373;
    box-shadow: 0 6px 10px rgba(0,0,0,0.2);
  }
/* ตาราง */
    /* ตารางเวลา */
    .bk-table{border:1px solid var(--line);border-radius:8px;overflow:hidden;margin-top:16px;}
    .bk-head{display:grid;grid-template-columns:repeat(12,1fr);}
    .bk-head > div{background:#fff;border-right:1px solid var(--line);padding:8px;text-align:center;font-weight:600}
    /* ตารางเวลา */

    .bk-status{display:grid;grid-template-columns:repeat(12,1fr)}

    /* คอลลัมตาราง */
    .bk-cell{position:relative;border-right:1px solid var(--line);border-bottom:1px solid var(--line);height:70px;display:flex;align-items:center;justify-content:center;font-weight:600}
    /* คอลลัมตาราง */

    /* ตัวหนังสือในคอลลัมตาราง */
    .bk-chip{position:absolute;top:6px;left:10px;font-size:12px}
    /* ตัวหนังสือในคอลลัมตาราง */
/* ตาราง */

    /* ลบ */
    .bk-del{position:absolute;top:26px;left:10px;background:#C91818;color:#fff;border:none;border-radius:6px;padding:2px 8px;font-size:12px}
    /* ลบ */

    /* ปุ่มเช็ค */
    .bk-check{transform:scale(1.2)}
    /* ปุ่มเช็ค */

    /* ช่องที่บอกว่าจองแล้ว */
    .bg-booked{background:var(--red)}
    /* ช่องที่บอกว่าจองแล้ว */

    /* ช่องที่จองได้สีเขียว */
    .bg-free{background:var(--green)}
    /* ช่องที่จองได้สีเขียว */

    /* ช่องที่รออนุมัติสีเหลือง */
    .bg-pending{background:var(--yellow)}
    /* ช่องที่รออนุมัติสีเหลือง */

    /* ช่องที่เต็มแล้วสีแดง */
    .bg-full{background:#f4a4a4}
    /* ช่องที่เต็มแล้วสีแดง */
  </style>

@php
     $times = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00'];

    $room     = $room    ?? ($rooms->first() ?? null);
    $roomId   = $room->id       ?? ($rooms->first()->id ?? 1);
    $roomCode = $room->room_id  ?? ($rooms->first()->id ?? '');
    $dayVal   = $date ?? now()->toDateString(); // แก้ตรงนี้ ใช้ $dayVal

  @endphp
  <script> function checkphone(){ /* เช็คเบอร์โทร ต้องมี 10 ตัว */
  let phone = document.getElementById("phone").value; 
  if (phone.length != 10) { 
    alert("กรุณากรอกเบอร์โทรให้ครบ 10 หลัก");
     e.preventDefault(); 
     /* ยกเลิกการส่งฟอร์ม */ 
     return; } } 
     function checkslot(){ /* เช็คเวลาจอง */ 
     let slots = document.querySelectorAll("input[name='slots[]']:checked"); 
     if (slots.length === 0) { 
      alert("กรุณาเลือกช่วงเวลาอย่างน้อย 1 ช่อง"); 
      e.preventDefault(); return; } } 
      function validate(){ 
        checkphone() 
        checkslot() 
        } </script>
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
          <div>
            <div class="bk-lbl">Room</div>
            <input class="bk-input" value="{{ $roomCode }}" disabled>
          </div>

          <div style="display:flex; gap:12px; margin-bottom:12px">
    <div style="flex:1">
      <div class="bk-lbl">Name</div>
      <input class="bk-input" name="first_name" placeholder="Name"
             value="{{ old('first_name') }}" required>
    </div>
    
    <div style="flex:1">
      <div class="bk-lbl">Last Name</div>
      <input class="bk-input" name="last_name" placeholder="Last Name"
             value="{{ old('last_name') }}" required>
    </div>
    <div style="flex:1">
      <div class="bk-lbl">Phone</div>
      <input class="bk-input" name="phone" id="phone" placeholder="Phone"
             value="{{ old('phone') }}" inputmode="numeric" pattern="\d{10}"
             maxlength="10" required>
    </div>
  </div>

  <div>
    <div class="bk-lbl">Detail</div>
    <input class="bk-input" name="detail" placeholder="Detail" value="{{ old('detail') }}">
  </div>


      <div class="bk-topbar">
        <button class="bk-btn" type="button">< เมื่อวาน</button>
        <div class="bk-title">📅 วันนี้ ({{ \Carbon\Carbon::parse($dayVal)->format('d/m/Y') }})</div>
        <button class="bk-btn" type="button">วันนี้ ></button>
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
        <br><br>
      <div class="flex justify-end mt-3">
        <button type="submit" class="btn-cancel" >ยกเลิก</button>
        <button type="submit" class="btn-book " >จอง</button>
      </div>
    </form>
  </div>
@endsection