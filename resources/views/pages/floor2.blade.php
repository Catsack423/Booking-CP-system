@extends('layouts.app')

@section('title', 'floor2')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    body {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        /* จัดแนวนอนกลาง */
        align-items: center;
        /* จัดแนวตั้งกลาง */
        min-height: 100vh;
        /* เต็มจอ */
        background-image: url("public/images/BG-login.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .floor-plan {
        background-color: white;
        padding: 10%;
        position: relative;
        width: 1200px;
        /* กำหนดขนาดรูป */
        height: auto;
        justify-content: center;
        align-self: center;
        border-radius: 5%;
    }

    .floor-plan img {
        margin-top: 10px;
        width: 100%;
        /* ปรับให้รูปเต็ม container */
        display: block;
    }

    .room-btn {
        position: absolute;
        cursor: pointer;
        transform: translate(-50%, -50%);
        width: 100px;
        height: 100px;
        width: 100px;
        height: 100px;
        padding: 5px 10px;
        border-radius: 50%;
        border: none;
    }

    .room-btn {
        cursor: pointer;
        background: rgba(5, 255, 80, 0.719);
        color: white;
        
    }
    .room-btn:hover {
        border: 1px solid black;
    }

    .room-btn-notavailable {
        cursor: default;
        background: rgba(255, 0, 21, 0.719);
        color: white;
    }

    .backgroundIMG {
        position: absolute;
        /* หรือ fixed ก็ได้ */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    /* กำหนดตำแหน่งปุ่มแต่ละห้อง */
    #room9228 {
        top: 40%;
        left: 24.6%;
    }
</style>
@section('content')

    <body>
        <img src="{{ asset('images/BG-login.jpg') }}" alt="error" class="backgroundIMG">
        <br><br><br><br><br><br><br>
        
        <div class="floor-plan">
            <h1 style="text-indent: 60px; font-size: 30px; text-decoration: underline;">ชั้น 2</h1><br>
            <img src="{{ asset('img/floor2map.png') }}" alt="Error">
            <div class="room-container">
                <a href="">
                    <button id="room9228" class="room-btn"></button>
                </a>
            </div>
        </div>
    </body>
@endsection
