@extends('layouts.layout')
       
@section('content')
    <adminhome :user="{{ Auth::user() }}" :lang="'{{ $lang }}'"></adminhome>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection