@extends('layouts.app')

@section('title', 'ชั้น 1')
<link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
<link rel="stylesheet" href="css/room.css">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    #CP9127 {
        top: 37.8%;
        left: 19.8%;
    }
</style>

@section('content')


    <body style="background: rgba(119, 118, 118, 0.137);">
        <?php
        $now = date('Y-m-d');
        ?>
        <div class="floor-plan">

            <h1 style="margin-left: 60px; font-size: 30px; text-decoration: underline;">ชั้น 1</h1><br>
            <div class="map-wrapper">
                <img src="{{ asset('img/floor1map.png') }}" alt="Error">
                {{--  คือยังว่าง true คือโดนจอง --}}
                @foreach ($rooms as $room)
                    @if ($room->status == false)
                        <a href="/booking/{{ $room->id }}/{{ $now }} " class="{{ request()->routeIs('Booking') ? 'active' : '' }}" ><button id="{{ $room->id }}" title="{{ $room->id }}" class="room-btn"></button></a>
                    @else
                        <a href=""><button id="{{ $room->id }}" class="room-btn-notavailable" disabled></button></a>
                    @endif
                @endforeach

            </div>
            @forelse ($requests as $data )
                <p>{{$data}}</p>
            @empty
                <p>Empty</p>
            @endforelse
    </body>
@endsection
