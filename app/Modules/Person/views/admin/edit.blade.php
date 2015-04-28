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
                                            @if($config['image']['order'])
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
                                                @if($config['image']['order'])
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

                                                    <a href="{{ array_get($config, 'image.baseUrl') . 'original/' . $image->image }}" class="btn btn-info btn-xs fancybox-crop"
                                                        data-w="{{ $size[0] }}"
                                                        data-h="{{ $size[1] }}"
                                                        data-image-id="{{ $image->id }}">
                                                        <i class="fa fa-crop"></i> Crop
                                                    </a>

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

                                @if($config['image']['multiple'] || (!$config['image']['multiple'] && count($item->images) < 1))


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

    <div id="fancy-footer" style="display: none">
        X:<span id="x"></span>&nbsp;
        Y:<span id="y"></span>&nbsp;
        W:<span id="w"></span>&nbsp;
        H:<span id="h"></span>&nbsp;

        {!! Form::open(array('route' => array("api.admin.image.crop", $item->id), 'method' => 'post', 'id' => 'jcrop-form')) !!}

        <div class="clearfix">
            <input type="hidden" name="id" value="{{$item->id}}">
            <input type="hidden" name="image_id" value="">
            <input type="hidden" name="x" value="">
            <input type="hidden" name="y" value="">
            <input type="hidden" name="w" value="">
            <input type="hidden" name="h" value="">
            <input type="submit" name="crop" value="Crop" class="btn btn-success btn-sm pull-right">
            <input type="button" name="fancy-close" value="Close" class="btn btn-default btn-sm pull-right right10 fancy-close">
        </div>

        {!! Form::close() !!}

    </div>

@stop

@section('scripts_bottom')
@parent
<script type="text/javascript">
    $(document).ready(function () {


        function initFancyBoxCrop(){
            $(".fancybox-crop").fancybox({

                afterShow: function () {
                    $('.fancybox-outer input[name=image_id]').val($(this.element).attr('data-image-id'))
                    $('.fancybox-inner').find('img').Jcrop({
                        allowMove: true,
                        onChange: updateCoords,
                        trueSize: [$(this.element).attr('data-w'), $(this.element).attr('data-h')]
                    });
                },
                beforeShow: function () {
                    $('#fancy-footer').clone().appendTo('.fancybox-outer').show();
                }
            });
        }

        initFancyBoxCrop();

        $(document).on('pjax:complete', function () {
            initFancyBoxCrop();
        });

        function updateCoords(c) //update the cropped image cords on change
        {
            console.log(c.x)
            $('.fancybox-outer #x').text(Math.round(c.x));
            $('.fancybox-outer #y').text(Math.round(c.y));
            $('.fancybox-outer #w').text(Math.round(c.w));
            $('.fancybox-outer #h').text(Math.round(c.h));

            $('.fancybox-outer input[name=x]').val(Math.round(c.x));
            $('.fancybox-outer input[name=y]').val(Math.round(c.y));
            $('.fancybox-outer input[name=w]').val(Math.round(c.w));
            $('.fancybox-outer input[name=h]').val(Math.round(c.h));
        };

        $(document).on('submit', '#jcrop-form', function (e) {
            e.preventDefault();
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax(
                    {
                        url: formURL,
                        type: "post",
                        data: postData,
                        success: function (data, textStatus, jqXHR) {
                            $.fancybox.close();
                            parent.location.reload(true);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Server error.')
                        }
                    });
        })

        $('#datatable-static').dataTable({
            bStateSave: true,
            iDisplayLength: 10,
            aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
        });

    });
</script>
@stop