@if (is_ajax())
    {!! Former::open_for_files()->class('added-form') !!}
@endif

@if(isset($item))

    {!! Former::hidden('id')->name("id[{$item->id}]") !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value('rte') !!}

    {!! Former::text('title')->addClass('input-sm')->name('title[]')->label('Title')->value($item->title) !!}

    {!! Former::textarea('value')->addClass('ckeditor')->name('value[]')->label('Value')->value($item->values[0]->value) !!}

@else

    {!! Former::hidden('id')->name('id[]') !!}

    {!! Former::hidden('type')->name('type[]')->value('rte') !!}

    {!! Former::text('title')->addClass('input-sm')->name('title[]')->label('Title') !!}

    {!! Former::textarea('value')->addClass('ckeditor')->name('value[]')->label('Value') !!}

@endif

@if (is_ajax())
    {!! Former::close() !!}
@endif
