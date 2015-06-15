<?php $contentType = 'gallery' ?>
@if(isset($item))

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id')->value($item->order) !!}

    {!! Former::hidden('id')->name("id[{$item->id}]")->value($item->id) !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value($item->type) !!}

    {!! Former::text('title')->addClass('input-sm')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::text('content')->name("content[{$item->id}]")->label('Content')->value($item->content) !!}


    @include("admin::_partials.model_content.image_template", compact('uniqid', 'item', 'uniqid', 'contentType'))

@else

    {!! Former::hidden('order')->name("order_new[{$uniqid}]")->addClass('order-id') !!}

    {!! Former::hidden('id')->name("id_new[{$uniqid}]") !!}

    {!! Former::hidden('type')->name("type_new[{$uniqid}]")->value($contentType) !!}

    {!! Former::text('title')->addClass('input-sm')->name("title_new[{$uniqid}]")->label('Title') !!}

    {!! Former::text('content')->name("content_new[{$uniqid}]")->label('Content') !!}



    @include("admin::_partials.model_content.image_template", compact('uniqid', 'contentType'))

@endif