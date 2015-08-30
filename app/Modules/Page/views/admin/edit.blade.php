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

        <ul class="nav nav-tabs tab-selector bottom10">
            <li class="active"><a href="{{ route("admin.{$moduleLower}.edit", $item->id) }}"><i class="fa fa-bars fa-fw"></i>Basic</a></li>
            <li class=""><a href="{{ route("admin.{$moduleLower}.content.edit", $item->id) }}"><i class="fa fa-folder-open-o fa-fw"></i> Content</a></li>
        </ul>

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

                                    {!! Former::text('lang')->disabled()->forceValue($lang) !!}

                                    {!! Former::text('title') !!}

                                    {!! Former::text('sub_title') !!}

                                    {!! Former::text('slug') !!}

                                    {!! Former::textarea('intro')->addClass('ckeditor') !!}

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

            @include("admin::_partials.images_form", ['item' => $item])

            {!! Former::close() !!}

            @if(array_get($config, 'image.crop'))
                @include("admin::_partials.crop_form", ['item' => $item])
            @endif
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