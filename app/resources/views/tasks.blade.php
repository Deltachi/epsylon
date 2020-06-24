@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="list-group">
                @for($i = 1; $i <= 9; $i++)
                    <a class="list-group-item list-group-item-action" href="/task/{{$i}}">Aufgabenstellung {{$i}}</a>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection
