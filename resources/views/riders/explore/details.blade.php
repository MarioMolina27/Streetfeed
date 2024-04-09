@extends('layouts.layout')

@section('content')
    <providerdetails :nickname="'{{ $nickname }}'" :user="{{ Auth::user() }}"></providerdetails>
@endsection

@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection