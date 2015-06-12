@if (is_ajax())
    {!! Former::open_for_files()->class('added-form') !!}
@endif

@if(isset($item))

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id')->value($item->order) !!}

    {!! Former::hidden('id')->name("id[{$item->id}]")->value($item->id) !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value($item->type) !!}

    {!! Former::text('title')->addClass('input-sm')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::text('content')->name("content[{$item->id}]")->label('Content')->value($item->content) !!}

    @if(get_related_item($item, 'values'))

        @foreach($item->values as $key => $value)

            {!! Former::hidden('value_id')->name("val_id[{$item->id}][{$value->id}]")->value($value->id) !!}

            {!! Former::text('value')->name("val_value[{$item->id}][{$value->id}]")->label('Value')->value($value->value) !!}

            {!! Former::hidden('value_type')->name("val_value_type[{$item->id}][{$value->id}]")->value($value->value_type) !!}

        @endforeach

    @else

        {!! Former::text('value')->name("val_value[{$item->id}]")->label('Value') !!}

        {!! Former::hidden('value_type')->name("val_value_type[{$item->id}]")->value('vrednost-001') !!}

        {!! Former::hidden('value_id')->name("val_value_id[{$item->id}]")->value(null) !!}

    @endif

@else

    {!! Former::hidden('order')->name("order_new[{$uniqid}]")->addClass('order-id') !!}

    {!! Former::hidden('id')->name("id_new[{$uniqid}]") !!}

    {!! Former::hidden('type')->name("type_new[{$uniqid}]")->value('text2') !!}

    {!! Former::text('title')->addClass('input-sm')->name("title_new[{$uniqid}]")->label('Title') !!}

    {!! Former::text('content')->name("content_new[{$uniqid}]")->label('Content') !!}

    {!! Former::text('value')->name("val_value_new[{$uniqid}][]")->label('Value')->value('1111') !!}
    {!! Former::hidden('value_type')->name("val_value_type_new[{$uniqid}][]")->value('neka vrednost11') !!}

    {!! Former::text('value')->name("val_value_new[{$uniqid}][]")->label('Value2')->value('2222') !!}
    {!! Former::hidden('value_type')->name("val_value_type_new[{$uniqid}][]")->value('neka vrednost22') !!}

    {!! Former::text('value')->name("val_value_new[{$uniqid}][]")->label('Value3')->value('3333') !!}
    {!! Former::hidden('value_type')->name("val_value_type_new[{$uniqid}][]")->value('neka vrednost33') !!}

    @include("admin::_partials.model_content.image2", ['uniqid' => $uniqid])

@endif

@if (is_ajax())
    {!! Former::close() !!}
@endif