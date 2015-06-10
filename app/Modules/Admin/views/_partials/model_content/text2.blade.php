@if (is_ajax())
    {!! Former::open_for_files()->class('added-form') !!}
@endif

@if(isset($item))

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id') !!}

    {!! Former::hidden('id')->name("id[{$item->id}]") !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value('text') !!}

    {!! Former::text('title')->addClass('input-sm')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::text('content')->name("content[{$item->id}]")->label('Content')->value($item->content) !!}


    @if(get_related_item($item, 'values'))

    {!! Former::text('value')->name("value[{$item->id}]")->label('Value')->value($item->content) !!}

    {!! Former::hidden('value_type')->name("value_type[{$item->id}]") !!}

    {!! Former::hidden('value_id')->name("value_id[{$item->values[0]->id}]") !!}

    @endif




@else

    {!! Former::hidden('order')->name('order_new[]')->addClass('order-id') !!}

    {!! Former::hidden('id')->name('id_new[]') !!}

    {!! Former::hidden('type')->name('type_new[]')->value('text') !!}

    {!! Former::text('title')->addClass('input-sm')->name('title_new[]')->label('Title') !!}

    {!! Former::text('content')->name('content_new[]')->label('Content') !!}


    {!! Former::text('value')->name('value_new[]')->label('Value') !!}

    {!! Former::hidden('value_type')->name('value_type_new[]') !!}

@endif

@if (is_ajax())
    {!! Former::close() !!}
@endif