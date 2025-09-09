@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
