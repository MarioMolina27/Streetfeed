@extends('layouts.layout-land')
       
@section('content')
    <landing :api-key="{{ json_encode($apiKeyOpenAI) }}"></landing>
@endsection

@section('imports')
    @vite(['resources/css/app-land.scss', 'resources/js/app-land.js'])
@endsection