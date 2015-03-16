@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">People index</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{--<table class="table table-striped table-bordered table-hover" id="dt-table">--}}

        {{--<tbody>--}}

        {{--</tbody>--}}
    {{--</table>--}}

    {!! $dtTable !!}


@stop

@section('scripts_bottom')
@parent

{!! $dtJavascript !!}



{{--<script type="text/javascript">--}}
    {{--$(document).ready(function() {--}}
        {{--oTable = $('#dt-table').DataTable({--}}
            {{--"searchDelay": 1000,--}}
            {{--"processing": true,--}}
            {{--"serverSide": true,--}}
            {{--"ajax": {--}}
                {{--"url": "{{ route('api.people.dt') }}"--}}
            {{--},--}}
            {{--"columns": [--}}
                {{--{data: 'created_at', name: 'created_at', title: 'zikica jo'},--}}
                {{--{data: 'title' },--}}
                {{--{data: 'slug'},--}}

{{--//                {data: 'actions', name: 'actions'}--}}
            {{--]--}}
        {{--});--}}
    {{--});--}}
{{--</script>--}}
@stop