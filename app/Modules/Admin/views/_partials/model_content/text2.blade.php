@if (is_ajax())
    {!! Former::open_for_files()->class('added-form') !!}
@endif

@if(isset($item))

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id') !!}

    {!! Former::hidden('id')->name("id[{$item->id}]")->value($item->id) !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value($item->type) !!}

    {!! Former::text('title')->addClass('input-sm')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::text('content')->name("content[{$item->id}]")->label('Content')->value($item->content) !!}

    @if(get_related_item($item, 'values'))

        @foreach($item->values as $key => $value)

            {!! Former::text('value')->name("value[{$item->id}][{$value->id}]")->label('Value')->value($value->value) !!}

            {!! Former::hidden('value_type')->name("value_type[{$item->id}][{$value->id}]")->value($value->value_type) !!}

            {!! Former::hidden('value_id')->name("value_id[{$item->id}][{$value->id}]")->value($value->id) !!}

        @endforeach

    @else

        {!! Former::text('value')->name("value[{$item->id}]")->label('Value') !!}

        {!! Former::hidden('value_type')->name("value_type[{$item->id}]")->value('vrednost-001') !!}

        {!! Former::hidden('value_id')->name("value_id[{$item->id}]")->value(null) !!}

    @endif

@else

    {{--{!! Former::hidden('order')->name('order_new[]')->addClass('order-id') !!}--}}

    {!! Former::hidden('id')->name('id_new[]') !!}

    {!! Former::hidden('type')->name('type_new[]')->value('text2') !!}

    {!! Former::text('title')->addClass('input-sm')->name('title_new[]')->label('Title') !!}

    {!! Former::text('content')->name('content_new[]')->label('Content') !!}


    {!! Former::text('value')->name('value_new[][]')->label('Value')->value('1111') !!}
    {!! Former::hidden('value_type')->name('value_type_new[][]')->value('neka vrednost11') !!}
    {!! Former::hidden('order')->name('order_new[][]')->value('557') !!}

    {!! Former::text('value')->name('value_new[][]')->label('Value2')->value('2222') !!}
    {!! Former::hidden('value_type')->name('value_type_new[][]')->value('neka vrednost22') !!}
    {!! Former::hidden('order')->name('order_new[][]')->value('557') !!}

    {!! Former::text('value')->name('value_new[][]')->label('Value3')->value('3333') !!}
    {!! Former::hidden('value_type')->name('value_type_new[][]')->value('neka vrednost33') !!}
    {!! Former::hidden('order')->name('order_new[][]')->value('557') !!}



@endif

@if (is_ajax())
    {!! Former::close() !!}
@endif