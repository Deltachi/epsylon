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
                            <form action="/lecturer/action">
                                @csrf
                                <div class="form-group">
                                    <select class="form-control" id="subjectSelect">
                                        @foreach($user->subjects as $subject)
                                            <option value="{{$subject->id}}">{{$subject->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 justify-content-between d-flex mb-4">
                                    <button class="btn btn-lg btn-primary p-3 btn-block mt-0 mx-2">Neue Prüfung erstellen</button>
                                    <button class="btn btn-lg btn-primary p-3 btn-block mt-0 mx-2">Prüfung bearbeiten</button>
                                </div>
                                <div class="col-12 justify-content-between d-flex">
                                    <button class="btn btn-lg btn-primary p-3 btn-block mt-0 mx-2">Prüfung aktivieren</button>
                                    <button class="btn btn-lg btn-primary p-3 btn-block mt-0 mx-2">Prüfungsabgabe bewerten</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
