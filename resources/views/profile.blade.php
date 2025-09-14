@extends('layouts.app')

@section('title', 'Profile')
<link rel="stylesheet" href="{{ asset('css/history.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@section('content')




<div class="container mx-auto px-4 py-6">
  <div class="wraplogin">
  <div class="actions">
    <a href="{{ route('profile') }}" class="btn">แก้ไขข้อมูลส่วนตัว</a>
    <a href="{{ route('HistoryBooking') }}" class="btn btn-primary">ดูประวัติการจอง</a>
  </div>
<div class="profile-content">
    <!-- Card 1: ข้อมูลส่วนตัว -->
    <div class="card">
        <div class="cardProfile-img">
            <img src="{{ Auth::user()->profile_photo_url }}" alt="avatar" class="user-avatar">
        </div>
        <h2>แก้ไขข้อมูลส่วนตัว</h2>
        @livewire('profile.update-profile-information-form')
    </div>

    <!-- Card 2: เปลี่ยนรหัสผ่าน -->
    <div class="card">
        <h2>เปลี่ยนรหัสผ่าน</h2>
        @livewire('profile.update-password-form')
    </div>
</div>
@endsection
