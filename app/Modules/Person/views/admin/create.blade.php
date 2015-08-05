@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }}
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

                                {!! Former::text('lang')->disabled()->forceValue($lang) !!}

                                {!! Former::text('first_name') !!}

                                {!! Former::text('last_name') !!}

                                {!!
                                    Former::text('job_title')->addClass('autocomplete')
                                    ->data_model($modelName)
                                    ->data_column('job_title')
                                    ->data_type('autocomplete-json')
                                !!}

                                @include('admin::_partials.color_picker',
                                   [
                                       'fieldName' => 'color',
                                       'label' => 'Color',
                                       'validationRules' => $validationRules,
                                   ]
                                )

                                @include('admin::_partials.color_picker',
                                    [
                                        'fieldName' => 'text_color',
                                        'label' => 'Text color',
                                        'validationRules' => $validationRules,
                                    ]
                                )

                                {!! Former::textarea('description') !!}

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