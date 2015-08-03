@if(isset($item))

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id')->value($item->order) !!}

    {!! Former::hidden('id')->name("id[{$item->id}]")->value($item->id) !!}

    {!! Former::hidden('encoded')->name("encoded[{$item->id}]")->value(1) !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value($item->type) !!}

    {!! Former::text('title')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::textarea('content')->name("content[{$item->id}][0]")->label('Content')->value(isset($item->content[0]) ? $item->content[0] : '') !!}


    @include('work::admin._partials.upload2',
         [
             'numOfItems' => 3,
             'elementType' => 'video_left',
             'elementSubType' => ['mp4', 'wma', 'ogg'],
             'labels' => ['Mp4', 'WMA', 'Ogg'],
             'item' => $item
         ]
     )

@else

    {!! Former::hidden('order')->name("order_new[{$uniqid}]")->addClass('order-id') !!}

    {!! Former::hidden('id')->name("id_new[{$uniqid}]") !!}

    {!! Former::hidden('encoded')->name("encoded_new[{$uniqid}]")->value(1) !!}

    {!! Former::hidden('type')->name("type_new[{$uniqid}]")->value('video_duo') !!}

    {!! Former::text('title')->name("title_new[{$uniqid}]")->label('Title') !!}

    {!! Former::textarea('content')->name("content_new[{$uniqid}][0]")->label('Content') !!}

    @include('work::admin._partials.upload',
        [
            'numOfItems' => 3,
            'elementType' => 'video_left',
            'elementSubType' => ['mp4', 'wma', 'ogg'],
            'labels' => ['Mp4', 'WMA', 'Ogg']
        ]
    )

    @include('work::admin._partials.upload',
         [
            'numOfItems' => 3,
            'elementType' => 'video_right',
            'elementSubType' => ['mp4', 'wma', 'ogg'],
            'labels' => ['Mp4', 'WMA', 'Ogg']
        ]
    )

@endif