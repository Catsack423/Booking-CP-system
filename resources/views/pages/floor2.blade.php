@extends('layouts.app')

@section('title', 'floor2')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: rgba(148, 138, 138, 0.562);
        font-family: 'Noto Sans Thai', sans-serif;
    }

    .floor-plan {
        background-color: rgb(245, 238, 238);
        padding: 2%;
        position: relative;
        width: 60vw;
        max-width: 1000px;
        border-radius: 5%;
        margin: auto;
    }

    .map-wrapper {
    position: relative;
    width: 100%;
    }

    .map-wrapper img {
    width: 100%;
    height: auto;
    display: block;
    }

    .floor-plan img {
        width: 100%;
        height: auto;
        display: block;
    }

    .room-btn {
        position: absolute;
        transform: translate(-50%, -50%);
        width: 10%;
        aspect-ratio: 1 / 1;
        border-radius: 50%;
        border: 3px solid black;
        cursor: pointer;
        background: rgba(5, 255, 80, 0.719);
        transition: transform 0.2s;
    }

    .room-btn:hover {
        transform: translate(-50%, -50%) scale(1.1);
        border: 2px solid black;
    }

    .room-btn-notavailable {
        background: rgba(255, 0, 21, 0.719);
        cursor: default;
    }


#room9228 {
    top: 30.4%;
    left: 18%;
}


#room9227 {
    top: 30.4%;
    left: 33.5%;
}


#room9226 {
    top: 30.4%;
    left: 48%;
}

</style>

@section('content')
<body style="background: rgba(119, 118, 118, 0.137);">
    <br><br><br><br><br><br><br>

    <div class="floor-plan">
        <h1 style="margin-left: 60px; font-size: 30px; text-decoration: underline;">ชั้น 2</h1><br>
        <div class="map-wrapper">
        <img src="{{ asset('img/floor2map.png') }}" alt="Error">
        <a href=""><button id="room9228" class="room-btn room-btn-notavailable"></button></a>
        <a href=""><button id="room9227" class="room-btn "></button></a>
        <a href=""><button id="room9226" class="room-btn"></button></a>
    </div>
</body>
@endsection