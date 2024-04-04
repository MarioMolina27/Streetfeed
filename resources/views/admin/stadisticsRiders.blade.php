@extends('layouts.layout')
       
@section('content')
    <riderstats></riderstats>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection