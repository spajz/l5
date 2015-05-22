@if (Request::ajax())
    {!! Former::open_for_files()->class('added-form') !!}
@endif
<?php if (!isset($item)) $item = new stdClass() ?>
<div class="row sortable-row remove-this" data-id="">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Text
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-info btn-xs btn-sort">
                        <i class="fa fa-arrows-v w20"></i>
                    </button>
                    <a href="{{ route("admin.model-content.destroy", get_object('item', 'id'))}}" class="btn btn-danger btn-xs"
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

                        {!! Former::text('value')->name('value[]')->label('Value')->value($item->values[0]->value) !!}

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
@if (Request::ajax())
    {!! Former::close() !!}
@endif