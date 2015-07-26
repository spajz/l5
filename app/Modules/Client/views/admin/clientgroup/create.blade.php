@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$mainModuleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }}
                Create
            </h1>
        </div>
    </div>

    <div id="pjax-container">

        <div id="info-box">{!! Notification::showAll() !!}</div>

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

                                {!! Former::text('title') !!}

                                {!! Former::text('slug') !!}

                                <div class="form-group required color-picker-input">
                                    <label for="color" class="control-label col-lg-2 col-sm-4">Color</label>
                                    <div class="col-lg-10 col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i></i></span>
                                            {!! Former::text('color')->raw() !!}
                                        </div>
                                    </div>
                                </div>

                                {!! Former::hidden('featured')->forceValue(0) !!}
                                {!! Former::checkbox('featured')->value(1) !!}

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