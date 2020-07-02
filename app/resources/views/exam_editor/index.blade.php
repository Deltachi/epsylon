@extends('layouts.app')

@section('title',"Modul-Übersicht")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container px-5">
                        <h2 class="display-4">Hallo {{$user->firstname}} {{$user->lastname}}!</h2>
                        <p class="lead">Hier finden Sie alle anstehenden Klausuren des Moduls
                            <strong>{{$subject->name}}</strong>.</p>
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
                        <th scope="col">Status der Klausur</th>
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
                            <td class="align-middle">
                                <div class="d-flex align-items-center ">
                                    <div class="mr-2 font-weight-bold {{$exam->status === 'open'?'text-danger': ($exam->status === 'pending'?'text-success':'text-muted')}}">{{$exam->status}}</div>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#exam_status_modal_{{$loop->iteration}}">
                                        Status ändern
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exam_status_modal_{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <form method="POST" action="{{route('exam.edit.status.update')}}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Hinweise zur Klausur:</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="input-group mb-2">
                                                            <select class="form-control" id="statusSelect" name="status">
                                                                <option {{$exam->status == 'draft' ? 'selected="selected"': ''}} value="draft">Draft (Entwurf)</option>
                                                                <option {{$exam->status == 'pending' ? 'selected="selected"': ''}} value="pending">Pending (Wartet auf Zeitraum)</option>
                                                                <option {{$exam->status == 'open' ? 'selected="selected"': ''}} value="open">Open (Klausur freigegeben)</option>
                                                                <option {{$exam->status == 'closed' ? 'selected="selected"': ''}} value="closed">Closed (Klausur abgelaufen) </option>
                                                                <option {{$exam->status == 'finished' ? 'selected="selected"': ''}} value="finished">Finished (Klausur korrigiert)</option>
                                                            </select>
                                                            <input type="hidden" id="examId" name="examId" value="{{$exam->id}}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="dismiss" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                                                        <button type="submit" class="btn btn-primary" data-not-dismiss="modal">Speichern</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-right">
                                <a class="btn btn-outline-info" href="/exam/edit/{{$subject->id}}/{{$exam->id}}">Klausur bearbeiten</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-script')

@stop
