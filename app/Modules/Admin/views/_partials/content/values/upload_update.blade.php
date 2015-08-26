@foreach($item->values as $key => $value)

    <?php $uniqidElement = uniqid() ?>

    <?php
    $field = Former::text('value')
        ->name("val_value[{$item->id}][{$value->id}]")
        ->label($value->value_type . ' ' . $value->value_sub_type)
        ->id($uniqidElement)->onclick('selectFileWithCKFinder(\'' . $uniqidElement . '\')')
        ->placholder('Click here to select a file.')
        ->value($value->value);

    if(in_array($value->value_type, ['video'])) {
        $field->help(view('admin::_partials.content.values.video_html', ['video' => $value]));
    };

    echo $field;
    ?>

    {!! Former::hidden('value_type')
        ->name("val_value_type[{$item->id}][{$value->id}]")
        ->value($value->value_type)
    !!}

    {!! Former::hidden('value_sub_type')
        ->name("val_value_sub_type[{$item->id}][{$value->id}]")
        ->value($value->value_sub_type)
    !!}

    {!! Former::hidden('value_id')
       ->name("val_id[{$item->id}][{$value->id}]")
       ->value($value->id)
    !!}

    {!! Former::hidden('value_content_id')
        ->name("val_content_id[{$item->id}][{$value->id}]")
        ->value($value->content_id)
    !!}

    {{--<div id="{{ $uniqidElement }}_frame" style="display: none;">--}}
        {{--<iframe src="{{ url('/') }}/assets/admin/fileman/index.html?integration=custom&type=files&txtFieldId={{ $uniqidElement }}"--}}
                {{--style="width:100%;height:100%" frameborder="0">--}}
        {{--</iframe>--}}
    {{--</div>--}}

@endforeach