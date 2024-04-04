@extends('layouts.layout')
       
@section('content')
    <providerstats></providerstats>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection