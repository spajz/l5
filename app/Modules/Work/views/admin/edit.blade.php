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
        <li class="{{ Session::get('settings.tab') == '#basic' ? 'active' : '' }}"><a href="#basic"><i class="fa fa-bars fa-fw"></i>Basic</a></li>
        <li class="{{ Session::get('settings.tab') == '#content' ? 'active' : '' }}"><a href="#content"><i class="fa fa-folder-open-o fa-fw"></i> Content</a></li>
    </ul>

    <div id="pjax-container">

    <div id="basic">

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

                                {!! Former::hidden('updated_at') !!}

                                {!! Former::text('lang')->disabled() !!}

                                {!! Former::text('title') !!}

                                {!! Former::text('sub_title') !!}

                                {!! Former::text('slug') !!}

                                {!! Former::textarea('intro')->addClass('ckeditor') !!}

                                {!! Former::textarea('description')->addClass('ckeditor') !!}

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

        @include("admin::_partials.images_form", ['item' => $item])

        {!! Former::close() !!}

        @if(array_get($config, 'image.crop'))
            @include("admin::_partials.crop_form", ['item' => $item])
        @endif
    </div>

    <div id="content">

        <div id="info-box">{!! Notification::showAll() !!}</div>

        <div class="row">
            <div class="col-xs-12">
                {!! Form::open() !!}
                <div class="form-group">
                    {!! Form::select('elements', $elements, null, array('class' => 'select2 add-element', 'data-module' => $moduleLower)) !!}
                    {!! Form::submit('Add', array('class' => 'btn btn-primary  add-element-btn')) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        {!!
        Former::open_for_files()->route("admin.{$moduleLower}.item.content.update2", $item->id)
        ->method('put')
        ->id('module-content-form')
        ->addClass('content-sortable')
        ->data_model('\App\Models\Content')
        ->data_pjax()
        !!}
        {!! Former::hidden('model_type')->value($modelName) !!}

        {!! Former::hidden('lang')->value(session('settings.language')) !!}

        <div class="content-form-box">

            @if($contents)

                @foreach($contents as $item)

                    @include("admin::_partials.content.template", ['item' => $item, 'type' => $item->type])

                @endforeach

            @endif

        </div>

        {!!
        $formButtons or
        Former::submit('Submit')->addClass('btn-success bottom10')->value('Save')
        !!}

        {!! Former::hidden('_token')->value(csrf_token()) !!}

        {!! Former::close() !!}

        @section('crop_form')
        @show

    </div>

    </div>

@stop

@section('scripts_bottom')
    @parent

    <script type="text/javascript">
        var dialog;
        function openCustomRoxy2(id){
            dialog = $('#' + id).dialog({modal:true, width:875,height:600});
        }
        function closeCustomRoxy2(){
//            $('#roxyCustomPanel2').dialog('close');
            dialog.dialog('close');
        }
    </script>

@stop