@foreach($item->values as $key => $value)

    <?php $uniqidElement = uniqid() ?>
    {!! Former::text('value')
    ->name("val_value[{$item->id}][{$value->id}]")
    ->label('Label')
    ->id($uniqidElement)->onclick('openCustomRoxy2(\'' . $uniqidElement . '_frame\')')
    ->placholder('Click here to select a file.')
    ->value($value->value)
    !!}

    {!! Former::hidden('value_type')
    ->name("val_value_type[{$item->id}][{$value->id}]")
    ->value($value->value_type)
    !!}

    {!! Former::hidden('value_sub_type')
    ->name("val_value_sub_type[{$item->id}][{$value->id}]")
    ->value($value->value_sub_type)
    !!}

    {!! Former::hidden('value_sub_type')
   ->name("val_id[{$item->id}][{$value->id}]")
   ->value($value->id)
   !!}

    <div id="{{ $uniqidElement }}_frame" style="display: none;">
        <iframe src="{{ url('/') }}/assets/admin/fileman/index.html?integration=custom&type=files&txtFieldId={{ $uniqidElement }}" style="width:100%;height:100%" frameborder="0">
        </iframe>
    </div>

@endforeach
