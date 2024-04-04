@extends('layouts.layout')

@section('content')
    <assignlocation :menusjson="{{ json_encode(json_encode($menusjson)) }}"></assignlocation>
@endsection


@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection