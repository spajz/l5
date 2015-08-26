@foreach($uploadFileFields as $k => $v)

    @if(is_array($v))
        @foreach($v as $vv)

            <?php $uniqidElement = uniqid(); ?>

            {!! Former::text('value')
                ->name("val_value_new[{$uniqid}][]")
                ->label($k . ' ' . $vv)
                ->id($uniqidElement)->onclick('selectFileWithCKFinder(\'' . $uniqidElement . '\')')
                ->placholder('Click here to select a file.')
            !!}

            {!! Former::hidden('value_type')
                ->name("val_value_type_new[{$uniqid}][]")
                ->value($k)
            !!}

            {!! Former::hidden('value_sub_type')
                ->name("val_value_sub_type_new[{$uniqid}][]")
                ->value($vv)
            !!}

        @endforeach
    @else

        <?php $uniqidElement = uniqid(); ?>

        {!! Former::text('value')
           ->name("val_value_new[{$uniqid}][]")
           ->label($k)
           ->id($uniqidElement)->onclick('selectFileWithCKFinder(\'' . $uniqidElement . '\')')
           ->placholder('Click here to select a file.')
        !!}

        {!! Former::hidden('value_type')
            ->name("val_value_type_new[{$uniqid}][]")
            ->value($k)
        !!}

    @endif
@endforeach