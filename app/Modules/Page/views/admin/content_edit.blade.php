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
            Former::open_for_files()->route("admin.{$moduleLower}.content.update", $item->id)
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

                    @foreach($contents as $contentItem)

                        @include("admin::_partials.content.template", ['contentItem' => $contentItem, 'type' => $contentItem->type])

                    @endforeach

                @endif

            </div>

            {!!
            $formButtons or
            Former::submit('Submit')->addClass('btn-success bottom10')->value('Save')
            !!}

            {!! Former::hidden('_token')->value(csrf_token()) !!}

            {!! Former::close() !!}

            @include("admin::_partials.crop_form")

        </div>

    </div>

@stop

@section('scripts_bottom')
    @parent

@stop