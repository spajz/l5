@if(isset($item))

    <div class="row sortable-row remove-this" data-id="">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Text
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

                            @include("admin::_partials.model_content." . $type, ['item' => $item])

                        </div>
                    </div>
                </div>
            </div>
        </div>
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

                            @include("admin::_partials.model_content." . $type)

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