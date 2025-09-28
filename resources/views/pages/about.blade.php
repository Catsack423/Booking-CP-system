@extends('layouts.app')

@section('title', 'เกี่ยวกับเรา')
<link rel="icon" href="{{ asset('images/logo-room-booking.png') }}" type="image/png">

<link rel="stylesheet" href="{{ asset('css/about.css') }}">

@section('content')
<div class="page-content">
    <div class="about-section">
        <div class="logo-container">
            <img src="{{ asset('images/logo-room-booking.png') }}" alt="Room Booking Logo">
        </div>

        <h1>เกี่ยวกับเรา</h1>

        <p>
            <span class="highlight">Room Booking System</span> 
            คือระบบที่พัฒนาขึ้นในการทำโปรเจคเพื่อ
            <strong>จองห้องประชุมหรือห้องเรียนในอาคารตึก วิทยวิภาสของคณะ วิทยาลัยการคอมพิวเตอร์</strong> 
            ได้อย่างรวดเร็ว ผ่านการใช้งานออนไลน์
        </p>

        <h2>วัตถุประสงค์ของเรา</h2>
        <p>
            1.ลดความยุ่งยากในการจองห้องแบบเดิม <br>
            2.เพิ่มความถูกต้อง ลดการจองซ้ำ <br>
            3.ช่วยให้ผู้ใช้ตรวจสอบสถานะห้องได้แบบ Real-time <br>
            4.รองรับการยกเลิกและแก้ไขการจองได้อย่างสะดวก
        </p>
        <h2>จัดทำโดย</h2>
        <p>
            1. นายณัฐพงศ์ กรธนกิจ รหัสนักศึกษา     673380038-9	<br>
            2. นายธนันชัย พันธราช รหัสนักศึกษา      673380042-8 <br>
            3. นายปวัฒน์  ปัดทุมมา  รหัสนักศึกษา    673380048-6 <br>
            4. นายพีรพัฒน์ ป้องกันยา รหัสนักศึกษา    673380053-3 <br>
            5. นายปิยะพล ตุ่นป่า    รหัสนักศึกษา     673380280-2 <br>
        </p>
    </div>
</div>
@endsection
