@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">People index</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>




    <table class="table table-striped table-bordered table-hover" id="dt-table">
        <thead>
        <tr>
            <th>Rendering engine</th>
            <th>Browser</th>
            <th>Platform(s)</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>




@stop

@section('scripts_bottom')
@parent
<script type="text/javascript">
    $(document).ready(function() {
        oTable = $('#dt-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('api.people.dt') }}"
            },
            "columns": [
                {data: 'title', name: 'title'},
                {data: 'slug', name: 'slug'},
                {data: 'created_at', name: 'created_at'}
//                {data: 'actions', name: 'actions'}
            ]
        });
    });
</script>
@stop