@extends("admin::_partials.model_content.template")

@if (is_ajax())
    {!! Former::open_for_files()->class('added-form') !!}
@endif

@if(isset($item))

    <div class="row sortable-row remove-this" data-id="">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Text Area
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-info btn-xs btn-sort">
                            <i class="fa fa-arrows-v w20"></i>
                        </button>
                        <a href="{{ route("api.admin.model-content.destroy", $item->id)}}" class="btn btn-danger btn-xs"
                           data-bb="remove"><i class="fa fa-trash-o"></i> Delete</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">

                            {!! Former::hidden('id')->name('id[]') !!}

                            {!! Former::hidden('type')->name('type[]')->value('textarea') !!}

                            {!! Former::text('title')->addClass('input-sm')->name('title[]')->label('Title') !!}

                            {!! Former::textarea('value')->name('value[]')->label('Value') !!}

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

@else

    <div class="row sortable-row remove-this" data-id="">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Text
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-info btn-xs btn-sort">
                            <i class="fa fa-arrows-v w20"></i>
                        </button>
                        <a href="" class="btn btn-danger btn-xs"
                           data-bb="remove"><i class="fa fa-trash-o"></i> Delete</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">

                            {!! Former::hidden('id')->name('id[]') !!}

                            {!! Former::hidden('type')->name('type[]')->value('text') !!}

                            {!! Former::text('title')->addClass('input-sm')->name('title[]')->label('Title') !!}

                            {!! Former::text('value')->name('value[]')->label('Value') !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif

@if (is_ajax())
    {!! Former::close() !!}
@endif