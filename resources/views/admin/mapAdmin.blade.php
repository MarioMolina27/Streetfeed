@extends('layouts.layout')
       
@section('content')
    <mapadmin :user="{{ Auth::user() }}" :lang="'{{ $lang }}'"></mapadmin>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection