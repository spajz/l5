@extends($layout)

@section('content')

    <div id="pjax-container">

        <div id="info-box">{!! Notification::showAll() !!}</div>

        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">
                    <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }}
                    Content
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <p>
                    @if($languages)
                        @foreach($languages as $lang)
                            @if($lang == session('settings.language'))
                                <a href="{{ route("admin.{$moduleLower}.content", $lang) }}" class="btn btn-default {{ $buttonSize or '' }}">{{ $lang }}</a>
                            @else
                                <a href="{{route("admin.{$moduleLower}.content", $lang) }}" class="btn btn-success {{ $buttonSize or '' }}">{{ $lang }}</a>
                            @endif
                        @endforeach
                    @endif
                </p>
            </div>
        </div>

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
            Former::open_for_files()->route("admin.{$moduleLower}.content.store", $lang)
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