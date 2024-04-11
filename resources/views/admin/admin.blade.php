@extends('layouts.layout')

@section('content')
    <paneluser :user="{{ Auth::user() }}" :lang="'{{ $lang }}'"></paneluser>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection