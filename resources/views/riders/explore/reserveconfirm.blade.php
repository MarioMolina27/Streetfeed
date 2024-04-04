@extends('layouts.layout')

@section('content')
    <reserveconfirmation :datareserve="{{ json_encode(json_encode($datareserve)) }}"></reserveconfirmation>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection