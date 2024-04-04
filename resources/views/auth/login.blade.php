@extends('layouts.layout')
       
@section('content')
    <login :nickname="'{{ "HOLA" }}'"></login>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection