@extends($layout)

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }} Edit
            </h1>
        </div>
    </div>

    <div id="pjax-container">

        {!! Former::open_for_files()->route("admin.{$moduleLower}.update", $item->id)->method('put') !!}

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

                                {!! Former::select('group_id')->options($groups)->class('select2')->label('Group')->required() !!}

                                {!! Former::text('name')->label('Name (username)')->required() !!}

                                {!! Former::text('email')->required() !!}

                                {!! Former::checkbox('change_password')->value(1)->unchecked_value(0) !!}

                                {!!
                                    Former::text('password')->forceValue('')
                                    ->help('<button type="button" data-random-string="[name=\'password\']" class="btn btn-success">
                                        Create random password
                                    </button> ')
                                !!}

                                {!! Former::text('first_name') !!}

                                {!! Former::text('last_name') !!}

                                {!! Former::checkbox('status')->value(1)->unchecked_value(0) !!}

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