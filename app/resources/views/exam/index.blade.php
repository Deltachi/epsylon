@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container px-5">
                        <h2 class="display-4">Hallo {{$user->firstname}} {{$user->lastname}}!</h2>
                        <p class="lead">Hier finden Sie alle anstehenden Klausuren Ihres aktuellen Semesters.</p>
                    </div>
                </div>
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fach</th>
                        <th scope="col">Kennung</th>
                        <th scope="col">Name</th>
                        <th scope="col">Zeitraum</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($exams as $exam)
                        <tr>
                            <th class="align-middle" scope="row">{{$loop->iteration}}</th>
                            <td class="align-middle">{{$exam->subject->name}}</td>
                            <td class="align-middle">{{$exam->id}}</td>
                            <td class="align-middle">{{$exam->title}}</td>
                            <td class="align-middle">
                                @if(isset($exam->begin, $exam->end))
                                <div class="d-flex align-items-center">
                                    <div>
                                        {{$exam->begin->format('d.m.Y')}}<br><strong>{{$exam->begin->format('H:i')}} Uhr</strong>
                                    </div>
                                    <span class="mx-4">bis</span>
                                    <div>
                                        {{$exam->end->format('d.m.Y')}}<br><strong>{{$exam->end->format('H:i')}} Uhr</strong>
                                    </div>
                                </div>
                                @else
                                    <span class="font-italic text-muted">Keine Angabe</span>
                                @endif
                            </td>
                            <td class="align-middle text-right">
                                @switch($exam->status)
                                    @case("pending")
                                    <a class="btn btn-outline-secondary disabled" href="#">Keine Bearbeitung möglich</a>
                                    @break
                                    @case("open")
                                    <a class="btn btn-outline-info" href="/exam/{{$exam->id}}">Starten</a>
                                    @break
                                    @case("closed")
                                    <a class="btn btn-outline-secondary disabled" href="#">Bearbeitungszeit abgelaufen</a>
                                    @break
                                    @case("finished")
                                    <a class="btn btn-outline-info" href="/result/{{$exam->id}}">Ergebnisse einsehen</a>
                                    @break
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
