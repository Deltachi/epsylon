@extends('layouts.app')

@section('title',"Dozenten-Übersicht")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container px-5">
                        <h2 class="display-4">Hallo {{$user->firstname}} {{$user->lastname}}!</h2>
                        <p class="lead">Was möchten Sie heute tun?</p>
                    </div>
                    <div class="container d-flex align-items-center justify-content-center">
                        <div class="col-6 p-3">
                            <form method="GET" action="{{action('HomeController@action')}}">
                                @csrf
                                <div class="input-group mb-2">
                                    <select class="form-control" id="subjectSelect" name="subject">
                                        @foreach($user->subjects as $subject)
                                            <option value="{{$subject->id}}">{{$subject->name}}</option>
                                        @endforeach
                                    </select>
                                    <!-- Button trigger modal -->
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addNewSubjectModal">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 justify-content-between d-flex p-0 mb-2">
                                    <input type="submit"
                                           name="action_exam_create"
                                           class="btn btn-lg btn-primary p-3 btn-block mt-0 mr-1"
                                           value="Neue Prüfung erstellen">
                                    <input type="submit"
                                           name="action_exam_edit"
                                           class="btn btn-lg btn-primary p-3 btn-block mt-0 ml-1"
                                           value="Prüfungen bearbeiten">
                                </div>
                                <div class="col-12 justify-content-between d-flex p-0">
                                    {{--<input type="submit"
                                           name="action_exam_activate"
                                           class="btn btn-lg btn-primary p-3 btn-block mt-0 mr-1"
                                           value="Prüfung aktivieren">--}}
                                    <input type="submit"
                                           name="action_exam_correct"
                                           class="btn btn-lg btn-primary p-3 btn-block mt-0"
                                           value="Prüfungsabgaben bewerten">
                                </div>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger d-flex flex-column justify-content-center align-items-center mt-2">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                            <!-- Modal -->
                            <div class="modal fade" id="addNewSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <form action="/subject" method="POST">
                                            @csrf

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Neues Modul hinzufügen</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="name" name="name"  placeholder="Name des Moduls">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" data-not-dismiss="modal">Hinzufügen</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
