@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }} Edit
            </h1>
        </div>
    </div>

    <div id="pjax-container">

        <div class="row">
            <div class="col-xs-12">
                <p>{!! $translateButtons or '' !!}</p>
            </div>
        </div>

        <div id="info-box">{!! Notification::showAll() !!}</div>

        {!! Former::open_for_files()->route("admin.{$moduleLower}.update", $item->id)->method('put')->data_pjax()->rules($validationRules) !!}

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

                                <div class="form-group required color-picker-input">
                                    <label for="color" class="control-label col-lg-2 col-sm-4">Color<sup>*</sup></label>
                                    <div class="col-lg-10 col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i></i></span>
                                            {!! Former::text('color')->raw() !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group required color-picker-input">
                                    <label for="color" class="control-label col-lg-2 col-sm-4">Text color<sup>*</sup></label>
                                    <div class="col-lg-10 col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i></i></span>
                                            {!! Former::text('text_color')->raw() !!}
                                        </div>
                                    </div>
                                </div>

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

        @include("admin::_partials.images_form", ['item' => $item, 'dynamic' => ['person', 0, 'thumb']])

        {!! Former::close() !!}

        @if(array_get($config, 'image.crop'))
            @include("admin::_partials.crop_form", ['item' => $item])
        @endif

    </div>

@stop

@section('scripts_bottom')
    @parent

@stop