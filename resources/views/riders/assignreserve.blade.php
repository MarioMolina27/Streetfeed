@extends('layouts.layout')

@section('content')
    <assignlocation :menusjson="{{ json_encode(json_encode($menusjson)) }}"></assignlocation>
@endsection