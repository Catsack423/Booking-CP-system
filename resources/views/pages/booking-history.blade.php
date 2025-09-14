@extends('layouts.app')
<link rel="stylesheet" href="css/booking-history.css">
@section('title', 'เกี่ยวกับเรา')
<link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
<style>
    .page-content {
        margin-top: 5%;
    }
</style>
@section('content')
    <div class="bt">
        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">แก้ไขข้อมูลส่วนตัว</a>
        <a href="{{ route('booking-history') }}" class="here {{ request()->routeIs('booking-history') ? 'active' : '' }}">
            ดูประวัติการจอง
        </a>

    </div>
    <div class="page-content">
        <h1 style="text-indent: 60px; font-size: 30px; text-decoration: underline;">
            ประวัติการจอง
        </h1>
    </div>
@endsection
