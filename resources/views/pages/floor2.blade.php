@extends('layouts.app')

@section('title', 'Floor2')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/room.css">
<style>
#CP9228 {
    top: 30.4%;
    left: 18%;
}


#CP9227 {
    top: 30.4%;
    left: 33.5%;
}


#CP9226 {
    top: 30.4%;
    left: 48%;
}

</style>

@section('content')
<body style="background: rgba(119, 118, 118, 0.137);">
    <?php
        $now = date('Y-m-d');
        ?>
    <div class="floor-plan">
        <h1 style="margin-left: 60px; font-size: 30px; text-decoration: underline;">ชั้น 2</h1><br>
        <div class="map-wrapper">
        <img src="{{ asset('img/floor2map.png') }}" alt="Error">
        @foreach ($rooms as $room)
                    @if ($room->status == false)
                        <a href="/booking/{{ $floor }}/{{ $room->id }}/{{ $now }}" class="{{ request()->routeIs('booking.*') ? 'active' : '' }}"><button id="{{ $room->id }}" title="{{ $room->id }}" class="room-btn"></button></a>
                    @else
                        <a href="/booking/{{ $floor }}/{{ $room->id }}/{{ $now }}" class="{{ request()->routeIs('booking.*') ? 'active' : '' }}"><button id="{{ $room->id }}" title="{{ $room->id }}" class="room-btn-notavailable"></button></a>                    @endif
                @endforeach
    </div>
</body>
@endsection

