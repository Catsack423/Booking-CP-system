@extends('layouts.app')


@section('title', 'ชั้น 5')
<link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
<link rel="stylesheet" href="css/room.css">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">

<style>
#CP9524 {
    top: 35.5%;
    left: 25%;
}

#CP9525 {
    top: 35.5%;
    left: 48.2%;
}

</style>


@section('content')
    <body style="background: rgba(119, 118, 118, 0.137);">
        <?php
        $now = date('Y-m-d');
        ?>

        <div class="floor-plan">
            <h1 style="margin-left: 60px; font-size: 30px; text-decoration: underline;">ชั้น 5</h1><br>
            <div class="map-wrapper">
                <img src="{{ asset('img/floor5map.png') }}" alt="Error">
                {{--  คือยังว่าง true คือโดนจอง --}}
                @foreach ($rooms as $room)
                    @if ($room->status == false)
                        <a href="/booking/{{ $room->id }}/{{ $now }}"><button id="{{ $room->id }}" title="{{ $room->id }}" class="room-btn"></button></a>
                    @else
                        <a href=""><button id="{{ $room->id }}" class="room-btn-notavailable" disabled></button></a>
                    @endif
                @endforeach
            </div>
    </body>
@endsection