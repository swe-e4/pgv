@extends('layouts.card')

@section('title', 'Login')

@section('content')
    <h1>{{ config('app.name') }} - Login</h1>
    <div class="alert error">
        <h1>Fehler</h1>
        <p>Die Anmeldung ist fehlgeschlagen.</p>
    </div>
    <form method="POST">
        <div class="group">
            <label for="email">E-Mail</label>
            <input type="email" id="email" name="email" placeholder="email@example.com">
        </div>
        <div class="group">
            <label for="password">Passwort</label>
            <input type="password" id="password" name="password" placeholder="*******">
        </div>
        <button class="full" type="submit">Login</button>
    </form>
    <small>PGV v0.1.0</small>
@endsection