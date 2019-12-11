@extends('layouts.panel')

@section('title', 'Übersicht')

@section('content')
<div class="box">
    <div class="table">
        <h1>Wochenplan</h1>
        <div class="scroll">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>
                            <a>
                                <span>Montag</span>
                            </a>
                        </th>
                        <th>
                            <a>
                                <span>Dienstag</span>
                            </a>
                        </th>
                        <th>
                            <a>
                                <span>Mittwoch</span>
                            </a>
                        </th>
                        <th>
                            <a>
                                <span>Donnerstag</span>
                            </a>
                        </th>
                        <th>
                            <a>
                                <span>Freitag</span>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i < 6; $i++)
                        <tr>
                            <td>
                                <a>
                                    <span>Gruppe A{{$i}}</span>
                                    <small>10:00-10:45 Uhr</small>
                                </a>
                            </td>
                            <td>
                                <a>
                                    <span>Gruppe B{{$i}}</span>
                                    <small>10:00-10:45 Uhr</small>
                                </a>
                            </td>
                            <td>
                                <a>
                                    <span>Gruppe C{{$i}}</span>
                                    <small>10:00-10:45 Uhr</small>
                                </a>
                            </td>
                            <td>
                                <a>
                                    <span>Gruppe D{{$i}}</span>
                                    <small>10:00-10:45 Uhr</small>
                                </a>
                            </td>
                            <td>
                                <a>
                                    <span>Gruppe E{{$i}}</span>
                                    <small>10:00-10:45 Uhr</small>
                                </a>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="box">
    <div class="table">
        <h1>Termine</h1>
        <div class="search">
            <i class="fas fa-search fa-xs"></i>
            <input type="text" placeholder="Suche" aria-label="Suche">
        </div>
        <div class="scroll">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="sort up">
                            <a>
                                <span>Gruppe</span>
                            </a>
                        </th>
                        <th class="sort">
                            <a>
                                <span>Betreuer</span>
                            </a>
                        </th>
                        <th class="sort">
                            <a>
                                <span>Nächster Termin</span>
                            </a>
                        </th>
                        <th>
                            <a>
                                <span>Aktion</span>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i < 6; $i++)
                        <tr>
                            <td>
                                <a>
                                    <span>Gruppe A{{$i}}</span>
                                </a>
                            </td>
                            <td>
                                <a>
                                    <span>Herr Muster</span>
                                </a>
                            </td>
                            <td>
                                <a>
                                    <span>Dienstag 10:15-11:00 Uhr</span>
                                </a>
                            </td>
                            <td>
                                <a>
                                    <span>Gruppendetails <i class="fas fa-angle-right"></i></span>
                                </a>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection