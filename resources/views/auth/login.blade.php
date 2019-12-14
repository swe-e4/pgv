@extends('layouts.card')

@section('title', __('Login'))

@section('content')
    <h1>{{ config('app.name') }} - {{ __('Login') }}</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="group">
            <label for="email">{{ __('E-Mail Address') }}</label>
            <input type="email" id="email" name="email" @error('email')class="error"@enderror  value="{{ old('email') }}" placeholder="email@example.com" autocomplete="email" autofocus required>

            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" id="password" name="password" @error('password')class="error"@enderror placeholder="**********" autocomplete="current-password" required>

            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="group checkbox">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>

        <button class="full" type="submit">Login</button>
    </form>
    <small>PGV v0.1.0</small>
@endsection