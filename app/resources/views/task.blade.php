@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-3">
            <ul class="list-group">
                <li class="list-group-item"><a href="/task/1">Aufgabenstellung 1</a></li>
                <li class="list-group-item"><a href="/task/2">Aufgabenstellung 2</a></li>
                <li class="list-group-item"><a href="/task/3">Aufgabenstellung 3</a></li>
                <li class="list-group-item"><a href="/task/4">Aufgabenstellung 4</a></li>
                <li class="list-group-item"><a href="/task/5">Aufgabenstellung 5</a></li>
                <li class="list-group-item"><a href="/task/6">Aufgabenstellung 6</a></li>
                <li class="list-group-item"><a href="/task/7">Aufgabenstellung 7</a></li>
                <li class="list-group-item"><a href="/task/8">Aufgabenstellung 8</a></li>
                <li class="list-group-item"><a href="/task/9">Aufgabenstellung 9</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <{{$component}} :data-task="'{{$task_data}}'"></{{$component}}>
        </div>
    </div>
</div>
@endsection
