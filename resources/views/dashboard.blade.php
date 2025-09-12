@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<br><br><br><br><br><br><br>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <div class="dashboard-content">
        <div class="dashboard-card">
            <h3>จำนวนผู้ใช้งาน</h3>
            <p>120 คน</p>
        </div>
        <div class="dashboard-card">
            <h3>ยอดจองวันนี้</h3>
            <p>45 ครั้ง</p>
        </div>
    </div>
@endsection
