@extends('layouts.layout')

@section('content')
    <paneldelivery :user="{{ Auth::user() }}" :lang="'{{ $lang }}'"></paneldelivery>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection