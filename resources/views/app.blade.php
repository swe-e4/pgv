@extends('layouts.panel')

@section('content')
<App :user="{{ auth()->user() }}" app_name="{{ config('app.name') }}"></App>

@endsection