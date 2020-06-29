@extends('layouts.app')

@section('content')
<div class="container">
    <exam :data-tasks="'{{json_encode($tasks, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG)}}'"
          :data-exam="'{{json_encode($exam, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG)}}'"
          :data-user="'{{json_encode($user, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG)}}'"
    ></exam>
</div>
@endsection

@section('page-script')
<script>

</script>
@stop

