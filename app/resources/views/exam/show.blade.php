@extends('layouts.app')

@section('title',$exam->subject->name . " | " . $exam->title)

@section('content')
<div class="container">
    <exam :data-exam="'{{json_encode($exam, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)}}'"
          :data-user="'{{json_encode($user, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)}}'"
    ></exam>
</div>
@endsection

@section('page-script')
<script>

</script>
@stop

