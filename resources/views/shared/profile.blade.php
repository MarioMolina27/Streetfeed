@extends('layouts.layout')
       
@section('content')
    <profile></profile>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection