@if (is_ajax())
    {!! Former::open_for_files()->class('added-form') !!}
@endif

@if(isset($item))

    {!! Former::hidden('id')->name("id[{$item->id}]") !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value('textarea') !!}

    {!! Former::text('title')->addClass('input-sm')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::textarea('value')->name("value[{$item->id}]")->label('Value')->value($item->values[0]->value) !!}

@else

    {!! Former::hidden('id')->name('id_new[]') !!}

    {!! Former::hidden('type')->name('type_new[]')->value('textarea') !!}

    {!! Former::text('title')->addClass('input-sm')->name('title_new[]')->label('Title') !!}

    {!! Former::textarea('value')->name('value_new[]')->label('Value') !!}

@endif

@if (is_ajax())
    {!! Former::close() !!}
@endif
