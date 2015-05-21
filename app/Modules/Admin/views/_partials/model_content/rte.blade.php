{!! Former::open_for_files()->class('added-form') !!}

<div class="row sortable-row remove-this" data-id="">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                RTE
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-info btn-xs btn-sort">
                        <i class="fa fa-arrows-v w20"></i>
                    </button>
                    <a href="{{ route("admin.model-content.destroy", null)}}" class="btn btn-danger btn-xs" data-bb="remove"><i class="fa fa-trash-o"></i> Delete</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">

                        {!! Former::text('title')->addClass('input-sm')->name('title[]')->label('Title') !!}

                        {!! Former::textarea('value')->addClass('ckeditor')->name('value[]')->label('Value') !!}

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

{!! Former::close() !!}