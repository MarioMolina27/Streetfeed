@extends('layouts.layout')
       
@section('content')
    <profile :user="{{ Auth::user() }}" :type_user="{{ Auth::user()->typeUsers }}"></profile>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection