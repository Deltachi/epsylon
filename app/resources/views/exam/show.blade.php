@extends('layouts.app')

@section('content')
<div class="container">
    <exam inline-template>
        <div class="row justify-content-center">
            <div class="col-3">
                <Timer :data-end="'{{$exam->end}}'"></Timer>
                <div class="card ">
                    <div class="card-header text-center">
                        <h5 class="m-0 font-weight-light">Aufgaben</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="exam-task-table table table-hover table-striped mb-0">
                            <tbody>
                            @foreach($exam->tasks as $task)
                                <tr @click="switchTask({{$loop->iteration}})" >
                                    <th class="align-middle text-center px-2 {{$task->answered ? 'bg-success text-white':''}}" scope="row">
                                        @if($task->answered)
                                            <span class="text-nowrap"><i class="fa fa-check"></i></span>
                                        @else
                                            <span class="text-nowrap"><i class="fa fa-minus"></i></span>
                                        @endif
                                    </th>
                                    <th class="align-middle text-center px-2" scope="row"><span class="font-weight-light">{{$loop->iteration}}</span> </th>
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
            <div class="col-md-9 d-flex flex-column justify-content-center">
                @foreach($tasks as $task)
                    <div id="task-{{$loop->iteration}}" class="task-container {{$loop->iteration === 1 ? 'active' : ''}}">
                        <task
                            :data-task="'{{$task}}'"
                            :data-exam="'{{json_encode($exam, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG)}}'"
                            :data-user-id="{{$user->id}}"
                            :is-active="isActive({{$loop->iteration}})"
                            :trigger-save="triggerSave"
                            @server-message="incomingMessage"
                        ></task>
                    </div>
                @endforeach
                <task-server-message
                    v-bind:message="message"
                    v-bind:message-type="messageType"
                    :trigger-handle="triggerMessage"
                ></task-server-message>
            </div>
        </div>
    </exam>
</div>
@endsection

@section('page-script')
<script>

</script>
@stop

