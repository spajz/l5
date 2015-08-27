<?php $contentType = 'image' ?>

@if(isset($item))

    <?php //dd($item->title)?>

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id') !!}

    {!! Former::hidden('id')->name("id[{$item->id}]") !!}

    {!! Former::hidden('type')->name("type[{$item->id}]") !!}

    {!! Former::text('title')->name("title[{$item->id}]")->label('Title') !!}

    {!! Former::select('sub_type')->name("sub_type[{$item->id}]")->options(config('admin.contentPosition'), $item->sub_type)->label('Position') !!}

    {!! Former::textarea('content')->name("content[{$item->id}]")->label('Content') !!}


    @include("admin::_partials.content.image_template", compact('uniqid', 'item', 'contentType'))

@else

    {!! Former::hidden('order')->name("order_new[{$uniqid}]")->addClass('order-id') !!}

    {!! Former::hidden('id')->name("id_new[{$uniqid}]") !!}

    {!! Former::hidden('type')->name("type_new[{$uniqid}]")->value($contentType) !!}

    {!! Former::text('title')->name("title_new[{$uniqid}]")->label('Title') !!}

    {!! Former::select('sub_type')->name("sub_type_new[{$uniqid}]")->options(config('admin.contentPosition'))->label('Position') !!}

    {!! Former::textarea('content')->name("content_new[{$uniqid}]")->label('Content') !!}


    @include("admin::_partials.content.image_template", compact('uniqid', 'contentType'))

@endif