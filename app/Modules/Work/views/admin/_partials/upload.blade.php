@for($i = 0; $i < $numOfItems; $i++)
    <?php
        $uniqidElement = uniqid();
        if(isset($labels[$i])){
            $label = $labels[$i];
        } else {
            $label = 'File ' . ($i + 1);
        }

        if(isset($elementSubType[$i])){
            $subType = $elementSubType[$i];
        } else {
            $subType = null;
        }
    ?>
    {!! Former::text('value')
    ->name("val_value_new[{$uniqid}][]")
    ->label($label)
    ->id($uniqidElement)->onclick('openCustomRoxy2(\'' . $uniqidElement . '_frame\')')
    ->placholder('Click here to select a file.')
    !!}

    {!! Former::hidden('value_type')
    ->name("val_value_type_new[{$uniqid}][]")
    ->value($elementType)
    !!}

    {!! Former::hidden('value_sub_type')
    ->name("val_value_sub_type_new[{$uniqid}][]")
    ->value($subType)
    !!}

    <div id="{{ $uniqidElement }}_frame" style="display: none;">
        <iframe src="{{ url('/') }}/assets/admin/fileman/index.html?integration=custom&type=files&txtFieldId={{ $uniqidElement }}" style="width:100%;height:100%" frameborder="0">
        </iframe>
    </div>
@endfor