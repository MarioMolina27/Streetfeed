@extends('layouts.layout')

@section('content')
    <providerdetails :nickname="'{{ $nickname }}'"></providerdetails>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection