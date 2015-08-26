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
            <li class=""><a href="{{ route("admin.{$moduleLower}.edit", $item->id) }}"><i class="fa fa-bars fa-fw"></i>Basic</a></li>
            <li class="active"><a href="{{ route("admin.{$moduleLower}.content.edit", $item->id) }}"><i class="fa fa-folder-open-o fa-fw"></i> Content</a></li>
        </ul>

        <div id="content">

            <div id="info-box">{!! Notification::showAll() !!}</div>

            <div class="row">
                <div class="col-xs-12">
                    {!! Form::open() !!}
                    <div class="form-group">
                        {!! Form::select('elements', $elements, null, array('class' => 'select2 add-element', 'data-module' => $moduleLower)) !!}
                        {!! Form::submit('Add', array('class' => 'btn btn-primary btn-sm add-element-btn')) !!}
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