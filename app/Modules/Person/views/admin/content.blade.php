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
                        <label for="elements">Add element:</label>
                        {!! Form::select('elements', $elements, null, array('class' => 'select2 add-element')) !!}
                        {!! Form::submit('Add', array('class' => 'btn btn-primary add-element-btn')) !!}
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

            @if($contents)

                @foreach($contents as $item)

                    @include("admin::_partials.model_content." . $item->type, compact('item'))

                @endforeach

            @endif

            {!! Former::submit('Submit') !!}

        {!! Former::close() !!}

    </div>

@stop

@section('scripts_bottom')
    @parent


    <script type="text/javascript">

        $(document).ready(function(){

            $('.content-sortable').sortable({
                axis: 'y',
                items: 'div.sortable-row',
                handle: '.btn-sort',
                forcePlaceholderSize: true,
                cancel: '',
                placeholder: 'sortable-placeholder',
                helper: function (e, ui) {
                    ui.children().each(function () {
                        $(this).width($(this).width());
                        $(this).height($(this).height());
                    });
                    return ui;
                },
                start: function (e, ui) {
                    $('.sortable-placeholder').height(ui.item.height());
                },
                stop: function (e, ui) {
                    colorSuccess(items);
                    colorSuccess(ui.item);
                }

            }).bind('sortupdate', function (e, ui) {
                var sort = [];
                $('div.sortable-row').each(function (index) {
                    sort[index + 1] = $(this).data('id');
                });
//                sortRows($('.content-sortable').data('model'), sort, ui.item);
            });


            function sortRows(model, sortData, item) {
                $.ajax({
                    url: baseUrlAdmin + '/api/sort-rows',
                    type: 'post',
                    data: {
                        "model": model,
                        "data": sortData
                    },
                    success: function (data, textStatus, jqXHR) {
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Server error.');
                    }
                });
            }


        })

    </script>

@stop