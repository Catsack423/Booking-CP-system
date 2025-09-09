@extends('layouts.app')

@section('title', 'floor1')

@section('content')
  <br><br><br><br><br><br><br>
  <h1 style="text-indent: 60px; font-size: 30px; text-decoration: underline;">ชั้น 1</h1><br>
  <?php
    redirect()->route('floor2');
  ?>

@endsection
