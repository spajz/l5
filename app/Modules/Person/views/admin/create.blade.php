@extends($layout)

@section('content')

    <div id="pjax-container" xmlns="http://www.w3.org/1999/html">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }}
                    Create
                </h1>
            </div>
        </div>

        @if($transButtons)
            <div class="row">
                <div class="col-lg-12">
                    <p>{!! $transButtons !!}</p>
                </div>
            </div>
        @endif

        {!! Former::open_for_files()->route("admin.{$moduleLower}.store")->method('post') !!}

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Basic Information
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">

                                {!! Former::hidden('id') !!}

                                {!! Former::text('first_name') !!}

                                {!! Former::text('last_name') !!}

                                {!! Former::text('job_title') !!}

                                {!! Former::textarea('description') !!}

                                {!! Former::text('lang')->forceValue($lang)->disabled() !!}

                                {!! Former::checkbox('status')->value(1) !!}

                                {!! $formButtons or '' !!}

                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

        {!! Former::close() !!}

    </div>

@stop