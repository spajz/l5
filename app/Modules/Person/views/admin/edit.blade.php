@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }} Edit
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <p>{!! $transButtons !!}</p>
        </div>
    </div>

    <div id="pjax-container">

        <div id="info-box">{!! Notification::showAll() !!}</div>

        {!! Former::open_for_files()->route("admin.{$moduleLower}.update", $item->id)->method('put')->data_pjax() !!}

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Basic Information
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">

                                {!! Former::hidden('id') !!}

                                {!! Former::text('first_name') !!}

                                {!! Former::text('last_name') !!}

                                {!! Former::text('job_title') !!}

                                {!! Former::textarea('description') !!}

                                {!! Former::text('lang')->value('sr') !!}

                                {!! Former::checkbox('status')->value(1) !!}

                                {!! $formButtons or '' !!}

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

        <div class="row">
            <div class="col-xs-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Images
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">

                                @if(count($item->images))
                                    <table class="table table-bordered table-striped table-hover sortable" data-model="{{  get_class($item->images[0]) }}">
                                @else
                                    <table class="table table-bordered table-striped table-hover">
                                @endif

                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Alt</th>
                                            <th>Upload</th>
                                            @if(array_get($config, 'image.order'))
                                            <th>Order</th>
                                            @endif
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @if(count($item->images))
                                        @foreach($item->images as $image)
                                            <?php $size = getimagesize(array_get($config, 'image.path') . 'original/' . $image->image); ?>
                                            <tr data-id="{{ $image->id }}">
                                                <td>

                                                    {!!
                                                        link_to_image(
                                                            $image,
                                                            $config,
                                                            [
                                                                'class' => 'img-thumbnail',
                                                            ],
                                                            [
                                                                'class' => 'fancybox', 'rel' => 'gallery',
                                                                'data-w' => $size[0],
                                                                'data-h' => $size[1],
                                                                'data-image-id' => $image->id,
                                                            ]
                                                        )
                                                    !!}
                                                </td>
                                                <td>
                                                    {!! Former::text("alt_update[{$image->id}]")->label(null)->value($image->alt)->placeholder('Enter alt text.') !!}
                                                </td>
                                                <td class="w200">
                                                    <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse&hellip;  <input type="file"  name="files_update[{{$image->id}}]">
                                                        </span>
                                                    </span>
                                                        <input type="text" class="form-control" readonly>
                                                    </div>
                                                </td>
                                                @if(array_get($config, 'image.order'))
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info btn-xs btn-sort">
                                                        <i class="fa fa-arrows-v w20"></i>
                                                    </button>
                                                </td>
                                                @endif
                                                <td class="text-center">
                                                    {!! $statusButton($image) !!}
                                                </td>
                                                <td class="text-center">

                                                    @if(array_get($config, 'image.crop'))
                                                    <a href="{{ array_get($config, 'image.baseUrl') . 'original/' . $image->image }}" class="btn btn-info btn-xs fancybox-crop"
                                                        data-w="{{ $size[0] }}"
                                                        data-h="{{ $size[1] }}"
                                                        data-image-id="{{ $image->id }}">
                                                        <i class="fa fa-crop"></i> Crop
                                                    </a>
                                                    @endif

                                                    <a href="{{ route('api.admin.image.destroy', $image->id) }}" class="btn btn-danger btn-xs" data-bb="confirmPjax">
                                                        <i class="fa fa-trash-o"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="colspan">There is no items.</td>
                                        </tr>
                                    @endif
                                    </tbody>

                                </table>

                                @if(array_get($config, 'image.multiple') || (!array_get($config, 'image.multiple') && count($item->images) < 1))


                                    <div class="form-group">
                                        <label class="col-xs-3 col-lg-2 control-label">New image upload</label>

                                        <div class="col-xs-9 col-lg-10">
                                            <div class="row bottom15">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" value="" name="alt_new[]"
                                                           placeholder="Enter alt text."/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <span class="btn btn-default btn-file">
                                                                Browse&hellip; <input type="file" multiple name="files_new[]">
                                                            </span>
                                                        </span>
                                                        <input type="text" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endif

                                {!! $formButtons or '' !!}

                            </div>
                            <!-- /.col-xs-12 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>

        {!! Former::close() !!}

    </div>

    @if(array_get($config, 'image.crop'))
    @include("admin::_partials.crop_form", ['item' => $item])
    @endif

@stop