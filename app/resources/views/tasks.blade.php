@extends('layouts.app')

@section('content')
<div id="app" class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <task{{ $task_id }}></task>
        </div>
    </div>
</div>
@endsection
