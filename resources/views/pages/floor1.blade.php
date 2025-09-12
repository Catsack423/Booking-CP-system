@extends('layouts.app')

@section('title', 'ชั้น 1')
<link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
@section('content')
  <title>ชั้น 1</title>
  <h1 style="text-indent: 60px; font-size: 30px; text-decoration: underline;">ชั้น 1</h1><br>
  {{-- testdata --}}
  @foreach ($rooms as $data )
    {{ $data }}
  @endforeach
  {{-- end --}}


  
@endsection
