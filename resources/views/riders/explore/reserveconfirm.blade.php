@extends('layouts.layout')

@section('content')
    <reserveconfirmation :datareserve="{{ json_encode(json_encode($datareserve)) }}"></reserveconfirmation>
@endsection