@extends('layouts.app')

@section('title', 'คู่มือการใช้งานระบบจองห้องเรียน')

@section('content')
<link rel="stylesheet" href="{{ asset('css/guide.css') }}">

<div class="manual-container">
    <h1 class="manual-title">วิธีการใช้งานระบบจองห้องเรียน</h1>

    <p class="manual-intro">
        ระบบนี้ใช้สำหรับการจองห้องเรียนในอาคารวิทยวิภาส โดยมีชั้นที่สามารถเลือกได้คือ ชั้น 1, 2, 4 และ 5 
        <strong>(หมายเหตุ: ไม่มีชั้น 3)</strong>
    </p>

    <div class="manual-step">
        <h2>1. หน้าเข้าสู่ระบบ</h2>
        <p>ผู้ใช้ต้องเข้าสู่ระบบก่อนทำการจอง หากยังไม่มีบัญชีให้กด "ลงทะเบียน"</p>
        <div>
            <h3>Sign In</h3>
            <img src="{{ asset('images/guide-pic/login.png') }}" alt="หน้าเข้าสู่ระบบ">
        </div>
        <div>
            <h3>Register</h3>
            <img src="{{ asset('images/guide-pic/register.png') }}" alt="หน้าเข้าสู่ระบบ">
        </div>
        
    </div>

    <div class="manual-step">
        <h2>2. เลือกชั้นเรียน</h2>
        <p>เลือกชั้นที่ต้องการจองห้อง (มีชั้น 1, 2, 4, 5)</p>
        <img src="{{ asset('images/guide-pic/select-floor.png') }}" alt="หน้าเลือกชั้น">
    </div>

    <div class="manual-step">
        <h2>3. จองห้องเรียน</h2>
        <p>กรอกข้อมูลที่จำเป็น เช่น วันที่ เวลา และรายละเอียดเพิ่มเติม จากนั้นกด "ยืนยันการจอง"</p>
        <img src="{{ asset('images/guide-pic/booking.png') }}" alt="หน้าจองห้องเรียน">
    </div>

    <div class="manual-step">
        <h2>4. โปรไฟล์ผู้ใช้</h2>
        <p>สามารถแก้ไขข้อมูลส่วนตัวหรือเปลี่ยนรหัสผ่านได้ที่หน้านี้</p>
        <img src="{{ asset('images/guide-pic/profile.png') }}" alt="หน้าโปรไฟล์ผู้ใช้">
    </div>

    <div class="manual-step">
        <h2>5. ประวัติการจอง</h2>
        <p>ผู้ใช้สามารถตรวจสอบการจองที่เคยทำไว้ รวมถึงแก้ไขหรือยกเลิกการจองได้</p>
        <img src="{{ asset('images/guide-pic/history.png') }}" alt="หน้าประวัติการจอง">
    </div>

    <div class="manual-step">
        <h2>6. สถานะการจอง</h2>
        <p>ผู้ใช้สามารถดูสถานะการอนุมัติหรือปฏิเสธการจองได้จากหน้านี้</p>
        <img src="{{ asset('images/guide-pic/status.png') }}" alt="หน้าสถานะการจอง">
    </div>

    <footer class="manual-footer">
        © 2025 ระบบจองห้องเรียน - คู่มือการใช้งาน
    </footer>
</div>
@endsection
