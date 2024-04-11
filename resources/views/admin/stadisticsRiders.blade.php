@extends('layouts.layout')
       
@section('content')
    <riderstats :user="{{ Auth::user() }}" :lang="'{{ $lang }}'"></riderstats>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection