@extends('layouts.layout')
       
@section('content')
    <providerdetails :provider="{{ json_encode($provider) }}"></providerdetails>
@endsection