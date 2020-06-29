@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-2">
            <Timer :data-end="'{{$exam->end}}'"></Timer>
            <div class="card ">
                <div class="card-header text-center">
                    <h5 class="m-0 font-weight-light">Aufgaben</h5>
                </div>
                <div class="card-body p-0">
                        <table class="exam-task-table table table-hover table-striped mb-0">
                            <tbody>
                                @foreach($exam->tasks as $task)
                                    <tr>
                                        <th class="align-middle text-center px-2 {{$loop->even ? 'bg-success text-white':''}}" scope="row">
                                            @if($loop->even)
                                                <i class="fa fa-check"></i>
                                            @else
                                                <i class="fa fa-minus"></i>
                                            @endif
                                        </th>
                                        <td class="align-middle">{{$task->title}}</td>
                                        <td class="align-middle text-right px-2">{{$task->points}}P</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <div class="card-footer">
                    Bearbeitungsfortschritt:
                    <div class="progress mb-4" >
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">50%</div>
                    </div>
                    <button type="button" class="btn btn-outline-success btn-block text-uppercase">Klausur abgeben</button>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            @foreach($tasks as $task)
                <Task :data-task="'{{$task}}'" :data-exam="'{{json_encode($exam, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG)}}'" :data-user-id="{{$user->id}}"></Task>
            @endforeach
        </div>
    </div>
</div>
@endsection

