@extends('layouts.layout')
       
@section('content')
    <adminhome :user="{{ $user }}"></adminhome>
@endsection