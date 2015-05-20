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
            Former::open_for_files()->route("admin.{$moduleLower}.store")
            ->method('post')
            ->id('module-content-form')
            ->addClass('content-sortable')
            ->data_model('\App\Models\ModelContent')
        !!}

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
                $('table.sortable tbody tr').each(function (index) {
                    sort[index + 1] = $(this).data('id');
                });
                sortRows($('.content-sortable').data('model'), sort, ui.item);
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