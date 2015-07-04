@extends($layout)

@section('content')

    <div id="pjax-container">

        <div id="info-box">{!! Notification::showAll() !!}</div>

        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">
                    <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }}
                    Create
                </h1>
            </div>
        </div>

        @if($transButtons)
            <div class="row">
                <div class="col-xs-12">
                    <p>{!! $transButtons !!}</p>
                </div>
            </div>
        @endif

        {!! Former::open_for_files()->route("admin.{$moduleLower}.store")->method('post')->rules($validationRules) !!}

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

                                {!! Former::hidden('trans_id')->value($trans_id) !!}

                                {!! Former::text('lang')->forceValue($lang)->disabled() !!}

                                {!! Former::hidden('lang')->forceValue($lang) !!}

                                {!! Former::text('first_name') !!}

                                {!! Former::text('last_name') !!}

                                {!! Former::text('job_title') !!}

                                {!! Former::textarea('description')->addClass('ckeditor') !!}

                                {!! Former::hidden('status')->forceValue(0) !!}
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