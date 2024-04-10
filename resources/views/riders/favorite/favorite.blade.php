@extends('layouts.layout')
       
@section('content')
    <panelfavorite :user="{{ Auth::user() }}" :lang="'{{ $lang }}'"></panelfavorite>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection