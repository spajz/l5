@if (is_ajax())
    {!! Former::open_for_files()->class('added-form') !!}
@endif

@if(isset($item))

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id') !!}

    {!! Former::hidden('id')->name("id[{$item->id}]") !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value('rte') !!}

    {!! Former::text('title')->addClass('input-sm')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::textarea('content')->addClass('ckeditor')->name("content[{$item->id}]")->label('Content')->value($item->content) !!}

@else

    {!! Former::hidden('order')->name('order_new[]')->addClass('order-id') !!}

    {!! Former::hidden('id')->name('id_new[]') !!}

    {!! Former::hidden('type')->name('type_new[]')->value('rte') !!}

    {!! Former::text('title')->addClass('input-sm')->name('title_new[]')->label('Title') !!}

    {!! Former::textarea('content')->addClass('ckeditor')->name('content_new[]')->label('Content') !!}

@endif

@if (is_ajax())
    {!! Former::close() !!}
@endif
