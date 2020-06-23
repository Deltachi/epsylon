@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-3">
            <div class="list-group">
                @for($i = 1; $i <= 9; $i++)
                    <a class="list-group-item list-group-item-action {{$task_id == $i ? 'active':''}}" href="/task/{{$i}}">Aufgabenstellung {{$i}}</a>
                @endfor
            </div>
        </div>
        <div class="col-md-9">
            <{{$component}} :data-task="'{{$task_data}}'"></{{$component}}>
        </div>
    </div>
</div>
@endsection
