@extends($layout)

@section('content')

    <div id="pjax-container">

        <div id="info-box">{!! Notification::showAll() !!}</div>

        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">
                    <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }}
                    Content
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                Add element:
                {!! Form::open() !!}
                {!! Form::select('elements', $elements, null, array('class' => 'select2 add-element')) !!}
                {!! Form::submit('Add', array('class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
            </div>
        </div>

        {!! Former::open_for_files()->route("admin.{$moduleLower}.store")->method('post')->id('ggg') !!}



        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Basic Information
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">

                                {!! Former::hidden('id') !!}

                                {!! Former::text('first_name') !!}

                                {!! Former::text('last_name') !!}

                                {!! Former::text('job_title') !!}

                                {!! Former::textarea('description')->addClass('ckeditor') !!}

                                {!! Former::text('lang')->value('sr') !!}

                                {!! Former::checkbox('status')->value(1) !!}

                                {!! $formButtons or '' !!}

                            </div>
                            <!-- /.col-xs-12 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-xs-12 -->
        </div>





        {!! Former::close() !!}

    </div>

@stop

@section('scripts_bottom')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {

            $('body').on('change', '.add-element', function (e) {
                e.preventDefault();
                var thisObj = $(this);
                $.ajax({
                    url: baseUrlAdmin + '/api/add-element',
                    type: 'get',
                    data: {
                        "element": thisObj.data('element')
                    },
                    success: function (data, textStatus, jqXHR) {
                        $('#ggg').append(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Server error.');
                    }
                });
            })

        })
    </script>
@stop