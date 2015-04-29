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
        <input type="hidden" name="alt_new[]" value="" id="alt_new_crop">
        <input type="hidden" name="description_new[]" value="" id="description_new_crop">
        <input type="submit" name="crop" value="Crop" class="btn btn-success btn-sm pull-right">
        <input type="button" name="fancy-close" value="Close" class="btn btn-default btn-sm pull-right right10 fancy-close">
    </div>

    {!! Form::close() !!}

</div>