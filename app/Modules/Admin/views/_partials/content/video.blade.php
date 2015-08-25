@if(isset($item))

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id')->value($item->order) !!}

    {!! Former::hidden('id')->name("id[{$item->id}]")->value($item->id) !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value($item->type) !!}

    {!! Former::text('title')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::select('sub_type')->name("sub_type[{$item->id}]")->options(config('admin.contentPosition'), $item->sub_type)->label('Position') !!}

    {!! Former::textarea('content')->name("content[{$item->id}]")->label('Content')->value($item->content) !!}

    @include('admin::_partials.content.values.upload_update',
        [
            'item' => $item,
        ]
    )

@else

    {!! Former::hidden('order')->name("order_new[{$uniqid}]")->addClass('order-id') !!}

    {!! Former::hidden('id')->name("id_new[{$uniqid}]") !!}

    {!! Former::hidden('type')->name("type_new[{$uniqid}]")->value('video') !!}

    {!! Former::text('title')->name("title_new[{$uniqid}]")->label('Title') !!}

    {!! Former::select('sub_type')->name("sub_type_new[{$uniqid}]")->options(config('admin.contentPosition'))->label('Position') !!}

    {!! Former::textarea('content')->name("content_new[{$uniqid}]")->label('Content') !!}

    @include('admin::_partials.content.values.upload_create',
        [
            'uploadFileFields' => $config['content']['element']['video'],
        ]
    )


@endif