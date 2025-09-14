@extends('layouts.app')

@section('title', 'ชั้น 4')
<link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
<link rel="stylesheet" href="css/room.css">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">

<style>
#CP9421 {
    top: 17.5%;
    left: 43%;
}


#CP9422 {
    top: 52.5%;
    left: 43%;
}

</style>

@section('content')
<body style="background: rgba(119, 118, 118, 0.137);">
    <?php
        $now = date('Y-m-d');
        ?>

    <div class="floor-plan">
        <h1 style="margin-left: 60px; font-size: 30px; text-decoration: underline;">ชั้น 4</h1><br>
        <div class="map-wrapper">
        <img src="{{ asset('img/floor4map.png') }}" alt="Error">
        @foreach ($rooms as $room)
                    @if ($room->status == false)
                        <a href="/booking/{{ $room->id }}/{{ $now }}"><button id="{{ $room->id }}" title="{{ $room->id }}" class="room-btn"></button></a>
                    @else
                        <a href="/booking/{{ $room->id }}/{{ $now }} "><button id="{{ $room->id }}" class="room-btn-notavailable" ></button></a>
                    @endif
        @endforeach
        
    </div>
</body>
@endsection