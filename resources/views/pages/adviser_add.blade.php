@extends('layouts.panel')

@section('title', 'Betreuer hinzufügen')

@section('content')
<div class="box">
    <h1>Betreuer hinzufügen</h1>
    <form method="POST">
        <div class="group">
            <label for="surname">Nachname</label>
            <input type="text" id="surname" name="surname" placeholder="Mustermann">
        </div>
        <div class="group">
            <label for="first_name">Vorname</label>
            <input type="text" id="first_name" name="first_name" placeholder="Max">
        </div>
        <div class="group">
            <label for="email">E-Mail</label>
            <input type="email" id="email" name="email" placeholder="email@example.com">
        </div>
        <div class="group">
            <label for="group">Gruppe</label>
            <select id="group" name="group" multiple size="10">
                @foreach (['A','B', 'C', 'D', 'E'] as $letter)
                    <optgroup label="{{ $letter }}">   
                        @for ($i = 1; $i < 6; $i++)
                            <option>{{ $letter }}{{ $i }}</option>
                        @endfor
                    </optgroup>
                @endforeach
            </select>
            <label for="group" class="description">Mehrere Gruppen können durch Drücken der Strg-Taste ausgewählt werden.</label>
        </div>
        <div class="button-list">
            <button class="half" type="submit">Betreuer hinzufügen</button>
            <button class="half gray" type="reset">Abbrechen</button>
        </div>
    </form>
</div>
@endsection