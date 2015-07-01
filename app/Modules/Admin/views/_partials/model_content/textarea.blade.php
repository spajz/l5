@if(isset($item))

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id')->value($item->order) !!}

    {!! Former::hidden('id')->name("id[{$item->id}]")->value($item->id) !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value($item->type) !!}

    {!! Former::text('title')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::textarea('content')->name("content[{$item->id}]")->label('Content')->value($item->content) !!}

@else

    {!! Former::hidden('order')->name('order_new[]')->addClass('order-id') !!}

    {!! Former::hidden('id')->name('id_new[]') !!}

    {!! Former::hidden('type')->name('type_new[]')->value('textarea') !!}

    {!! Former::text('title')->name('title_new[]')->label('Title') !!}

    {!! Former::textarea('content')->name('content_new[]')->label('Content') !!}

@endif