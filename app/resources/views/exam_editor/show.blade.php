@extends('layouts.app')

@section('title',"Klausur-Editor")

@section('content')
    <div class="container">
        <exam-editor :data-exam="'{{json_encode($exam, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG)}}'"
        ></exam-editor>
    </div>

@endsection

@section('page-script')
<script>

</script>
@stop

