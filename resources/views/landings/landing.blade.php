@extends('layouts.layout-land')
       
@section('content')
    <landing></landing>
@endsection

@section('imports')
    @vite(['resources/css/app-land.scss', 'resources/js/app-land.js'])
@endsection