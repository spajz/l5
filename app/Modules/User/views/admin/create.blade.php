@extends($layout)

@section('content')

    <div id="pjax-container" xmlns="http://www.w3.org/1999/html">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }} Create
                </h1>
            </div>
        </div>

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

                                {!! Former::select('group_id')->options($groups)->class('select2')->label('Group')->required() !!}

                                {!! Former::text('name')->label('Name (username)')->required() !!}

                                {!! Former::text('email')->required() !!}

                                {!!
                                    Former::text('password')
                                    ->required()
                                    ->append('<button class="btn btn-success" type="button" data-random-string="[name=\'password\']">
                                    Create random password</button>')
                                !!}

                                {!! Former::text('first_name') !!}

                                {!! Former::text('last_name') !!}

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