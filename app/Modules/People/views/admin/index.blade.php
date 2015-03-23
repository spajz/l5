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

    <script type="text/javascript">
        $(document).ready(function () {
            $('body').on('click', '*[data-bb="confirm"]', function (e) {
                e.preventDefault();
                var href = $(this).attr('href');
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) window.location.href = href;
                });
            })
        })
    </script>

@stop