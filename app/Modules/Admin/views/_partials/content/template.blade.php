@if (is_ajax())
    <!--
    {!! Former::open_for_files()->class('added-form') !!}
    -->
@endif
<?php $elementView = $config['content']['elementView'] ?>

@if(isset($contentItem))

    <?php  Former::populate($contentItem) ?>

    <div class="row sortable-row remove-this" data-id="{{ $contentItem->id }}">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="btn btn-primary btn-xs btn-toggle">
                        <i class="fa fa-caret-square-o-down"></i>
                    </button>
                    Type: {{ str_replace('_', ' ', $type) }}
                    <div class="btn-group pull-right">
                        @include('admin::_partials.content.translate_buttons', ['item' => $contentItem])
                        <button type="button" class="btn btn-info btn-xs btn-sort">
                            <i class="fa fa-arrows-v w20"></i>
                        </button>
                        <a href="{{ route("api.admin.model-content.destroy", $contentItem->id)}}" class="btn btn-danger btn-xs"
                           data-bb="remove"><i class="fa fa-trash-o"></i> Delete</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">

                            @include("admin::_partials.content." . array_get($elementView, $type, $type), ['item' => $contentItem, 'uniqid' => uniqid(), 'type' => $type])

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
                    <button type="button" class="btn btn-primary btn-xs btn-toggle">
                        <i class="fa fa-caret-square-o-down"></i>
                    </button>
                    Type: {{ str_replace('_', ' ', $type) }}
                    <div class="btn-group pull-right">
                        @include('admin::_partials.content.translate_buttons')
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

                            @include("admin::_partials.content." . array_get($elementView, $type, $type), ['uniqid' => uniqid(), 'type' => $type])

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif

@if (is_ajax())
    <!--
    {!! Former::close() !!}
    -->
@endif