@extends('admin.layout')
@section('pages','Dashboard')
@section('content')
<h3>Selamat datang ke dashboard </h3>
<h4>{{ Auth::user()->name }}</h4>
@endsection
