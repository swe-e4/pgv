@extends('layouts.clean')

@section('title', 'Home')

@section('content')
    <App :user="{{ auth()->user() }}"></App>
@endsection