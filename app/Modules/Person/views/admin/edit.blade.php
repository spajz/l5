@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }} Edit
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <p>{!! $transButtons !!}</p>
        </div>
    </div>

    <ul class="nav nav-tabs tab-selector bottom10">
        <li class="active"><a href="#basic"><i class="fa fa-bars fa-fw"></i>Basic</a></li>
        <li><a href="#content"><i class="fa fa-folder-open-o fa-fw"></i> Content</a></li>
    </ul>

    <div id="basic">
        <div id="pjax-container">

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

            @include("admin::_partials.images_form", ['item' => $item])

            {!! Former::close() !!}

        </div>

        @if(array_get($config, 'image.crop'))
            @include("admin::_partials.crop_form", ['item' => $item])
        @endif
    </div>


    <div id="content">

        <div class="row">
            <div class="col-xs-12">
                {!! Form::open() !!}
                <div class="form-group">
                    {!! Form::select('elements', $elements, null, array('class' => 'select2 add-element')) !!}
                    {!! Form::submit('Add', array('class' => 'btn btn-primary  add-element-btn')) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        {!!
        Former::open_for_files()->route("admin.{$moduleLower}.item.content.update", $item->id)
        ->method('post')
        ->id('module-content-form')
        ->addClass('content-sortable')
        ->data_model('\App\Models\ModelContent')
        !!}
        {!! Former::hidden('model_type')->value($modelName) !!}

        {!! Former::hidden('lang')->value(session('settings.language')) !!}

        <div class="content-form-box">

            @if($contents)

                @foreach($contents as $item)

                    @include("admin::_partials.model_content.template", ['item' => $item, 'type' => $item->type])

                @endforeach

            @endif

        </div>

        {!! Former::close() !!}

        @section('crop_form')
        @show

    </div>


@stop