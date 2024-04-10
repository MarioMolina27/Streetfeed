@extends('layouts.layout')
       
@section('content')
    <panelexplore :user="{{ Auth::user() }}" :lang="'{{ $lang }}'"></panelexplore>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection