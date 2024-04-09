@extends('layouts.layout')
       
@section('content')
    <riderstats :user="{{ Auth::user() }}"></riderstats>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection