@extends('layouts.layout')
       
@section('content')
    <panelfavorite></panelfavorite>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection