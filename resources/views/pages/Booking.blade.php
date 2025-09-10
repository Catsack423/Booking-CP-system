@extends('layouts.app')
<style>
    body {
        
        margin: 100px ;
        padding: 0;
        display: flex;
        justify-content: center;

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
        width: 110px;
        height: 110px;
        width: 110px;
        height: 110px;
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
@section('title', 'Booking')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">

@section('content')
<div class="floor-plan">


</div>

@endsection