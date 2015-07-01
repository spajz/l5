@if(isset($item))

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id')->value($item->order) !!}

    {!! Former::hidden('id')->name("id[{$item->id}]")->value($item->id) !!}

    {!! Former::hidden('encoded')->name("encoded[{$item->id}]")->value(1) !!}

    {!! Former::hidden('updated_at')->name("updated_at[{$item->id}]")->value($item->updated_at) !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value($item->type) !!}

    {!! Former::text('title')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::text('content')->name("content[{$item->id}]")->label('Content')->value($item->content) !!}

@else

    {!! Former::hidden('order')->name('order_new[]')->addClass('order-id') !!}

    {!! Former::hidden('id')->name('id_new[]') !!}

    {!! Former::hidden('encoded')->name("encoded_new[]")->value(1) !!}

    {!! Former::hidden('type')->name('type_new[]')->value('text') !!}

    {!! Former::text('title')->name('title_new[]')->label('Title') !!}

    {!! Former::text('content')->name('content_new[]')->label('Content') !!}

@endif
