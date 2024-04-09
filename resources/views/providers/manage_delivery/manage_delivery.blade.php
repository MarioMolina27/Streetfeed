@extends('layouts.layout')
       
@section('content')
    <managedelivery :user="{{ Auth::user() }}"></managedelivery>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection