@extends('layouts.layout')

@section('content')
    <assignlocation :menusjson="{{ json_encode(json_encode($menusjson)) }}" :user="{{ Auth::user() }}" :lang="'{{ $lang }}'" :type_user="{{ Auth::user()->typeUsers }}"></assignlocation>
@endsection


@section('imports')
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
@endsection