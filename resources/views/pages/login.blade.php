@extends('layouts.card')

@section('title', 'Login')

@section('content')
    <h1>{{ config('app.name') }} - Login</h1>
    <div class="alert error">
        <h1>Fehler</h1>
        <p>Die Anmeldung ist fehlgeschlagen.</p>
    </div>
    <form method="POST" action="{{ route('login') }}>
        @csrf
        <div class="group">
            <label for="email">E-Mail</label>
            <input type="email" id="email" name="email" placeholder="email@example.com">

            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="group">
            <label for="password">Passwort</label>
            <input type="password" id="password" name="password" placeholder="*******">

            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        
        <div class="group">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>

        <button class="full" type="submit">Login</button>
    </form>
    <small>PGV v0.1.0</small>
@endsection