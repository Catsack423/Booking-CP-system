@extends('layouts.app')

@section('title', 'floor1')
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
        background: rgba(148, 138, 138, 0.562);
    }


    .floor-plan {
        background-color: rgb(245, 238, 238);
        padding: 5% 5% 5% 5%;
        position: relative;
        width: 60vw;
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
        width: 113px;
        height: 113px;
        width: 113px;
        height: 113px;
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


    /* กำหนดตำแหน่งปุ่มแต่ละห้อง */
    #room9127 {
        top: 44.5%;
        left: 22.9%;
    }
</style>
@section('content')
  <body style="background: rgba(119, 118, 118, 0.137);">
        <br><br><br><br><br><br><br>

        <div class="floor-plan">
            <h1 style="text-indent: 60px; font-size: 30px; text-decoration: underline;">ชั้น 1</h1><br>
            <img src="{{ asset('img/floor1map.png') }}" alt="Error">
            <div class="room-container">
                <a href="{{ route('Booking') }}" class="{{ request()->routeIs('Booking') ? 'active' : '' }}">
                    <button id="room9127" class="room-btn"></button>
                </a>
            </div>
        </div>
    </body>
  
@endsection
