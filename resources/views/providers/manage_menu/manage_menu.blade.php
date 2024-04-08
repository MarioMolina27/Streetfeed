@extends('layouts.layout')
       
@section('content')
    <panelmenu :lang="'{{ $lang }}'"></panelmenu>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection