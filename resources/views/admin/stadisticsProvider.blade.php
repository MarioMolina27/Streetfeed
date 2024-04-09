@extends('layouts.layout')
       
@section('content')
    <providerstats :user="{{ Auth::user() }}"></providerstats>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection