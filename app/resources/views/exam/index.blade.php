@extends('layouts.app')

@section('title',"Klausuren-Übersicht")

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
                        <th scope="col">Allgemeine Hinweise</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($exams as $exam)
                        @if($exam->status !== 'draft')
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
                                <td class="align-middle">
                                    @if($exam->terms)
                                        <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#exam_terms_{{$loop->iteration}}">
                                                Ansehen
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exam_terms_{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Hinweise zur Klausur:</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {!! $exam->terms !!}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endif
                                </td>
                                <td class="align-middle text-right">
                                    @switch($exam->status)
                                        @case("pending")
                                        <a class="btn btn-outline-secondary disabled" href="#">Keine Bearbeitung möglich</a>
                                        @break
                                        @case("open")
                                        @if($exam->pivot->state == 'pristine')
                                            <a class="btn btn-success" href="/exam/{{$exam->id}}">Bearbeitung beginnen</a>
                                        @elseif($exam->pivot->state == 'dirty')
                                            <a class="btn btn-outline-success" href="/exam/{{$exam->id}}">Bearbeitung fortsetzen</a>
                                        @else
                                            <a class="btn btn-outline-primary" href="/exam/{{$exam->id}}">Erneut bearbeiten</a>
                                        @endif
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
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-script')

@stop
