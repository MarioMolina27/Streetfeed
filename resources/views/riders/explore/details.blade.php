@extends('layouts.layout')

@section('content')
    <providerdetails :nickname="'{{ $nickname }}'"></providerdetails>
@endsection