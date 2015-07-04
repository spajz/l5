@if(isset($item))

    {!! Former::hidden('order')->name("order[{$item->id}]")->addClass('order-id')->value($item->order) !!}

    {!! Former::hidden('id')->name("id[{$item->id}]")->value($item->id) !!}

    {!! Former::hidden('encoded')->name("encoded[{$item->id}]")->value(1) !!}

    {!! Former::hidden('type')->name("type[{$item->id}]")->value($item->type) !!}

    {!! Former::text('title')->name("title[{$item->id}]")->label('Title')->value($item->title) !!}

    {!! Former::textarea('content')->name("content[{$item->id}][0]")->label('Content')->value(isset($item->content[0]) ? $item->content[0] : '') !!}


    <?php $uniqid_01 = uniqid() ?>

    {!! Former::text('content')
    ->name("content[{$item->id}][1]")
    ->label('Clip 1')
    ->value(isset($item->content[1]) ? $item->content[1] : '')
    ->id($uniqid_01)->onclick('openCustomRoxy2(\'' . $uniqid_01 . '_frame\')')
    ->placholder('Click here to select a file')
    ->help('<a href="#'. $uniqid_01 . '_clip" class="fancybox">Preview video</a>')
    !!}

    <div id="{{ $uniqid_01 }}_clip" style="display: none">
        @include("admin::_partials.videojs_template", ['videoSrc' => asset($item->content[1])])
    </div>

    <div id="{{ $uniqid_01 }}_frame" style="display: none;">
        <iframe src="{{ url('/') }}/assets/admin/fileman/index.html?integration=custom&type=files&txtFieldId={{ $uniqid_01 }}" style="width:100%;height:100%" frameborder="0">
        </iframe>
    </div>
    <?php $uniqid_02 = uniqid() ?>

    {!! Former::text('content')
        ->name("content[{$item->id}][2]")
        ->label('Clip 2')
        ->value(isset($item->content[2]) ? $item->content[2] : '')
        ->id($uniqid_02)->onclick('openCustomRoxy2(\'' . $uniqid_02 . '_frame\')')
        ->placholder('Click here to select a file')
        ->help('<a href="#'. $uniqid_02 . '_clip" class="fancybox">Preview video</a>')
    !!}

    <div id="{{ $uniqid_02 }}_clip" style="display: none">
        @include("admin::_partials.videojs_template", ['videoSrc' => asset($item->content[2])])
    </div>
    
    <div id="{{ $uniqid_02 }}_frame" style="display: none;">
        <iframe src="{{ url('/') }}/assets/admin/fileman/index.html?integration=custom&type=files&txtFieldId={{ $uniqid_02 }}" style="width:100%;height:100%" frameborder="0">
        </iframe>
    </div>

@else

    {!! Former::hidden('order')->name("order_new[{$uniqid}]")->addClass('order-id') !!}

    {!! Former::hidden('id')->name("id_new[{$uniqid}]") !!}

    {!! Former::hidden('encoded')->name("encoded_new[{$uniqid}]")->value(1) !!}

    {!! Former::hidden('type')->name("type_new[{$uniqid}]")->value('video_duo') !!}

    {!! Former::text('title')->name("title_new[{$uniqid}]")->label('Title') !!}

    {!! Former::textarea('content')->name("content_new[{$uniqid}][0]")->label('Content') !!}


    <?php $uniqid_01 = uniqid() ?>

    {!! Former::text('content')
    ->name("content_new[{$uniqid}][1]")
    ->label('Clip 1')
    ->id($uniqid_01)->onclick('openCustomRoxy2(\'' . $uniqid_01 . '_frame\')')
    ->placholder('Click here to select a file.')
    !!}


    <div id="{{ $uniqid_01 }}_frame" style="display: none;">
        <iframe src="{{ url('/') }}/assets/admin/fileman/index.html?integration=custom&type=files&txtFieldId={{ $uniqid_01 }}" style="width:100%;height:100%" frameborder="0">
        </iframe>
    </div>
    <?php $uniqid_02 = uniqid() ?>

    {!! Former::text('content')
    ->name("content_new[{$uniqid}][2]")
    ->label('Clip 2')
    ->value(isset($item->content[2]) ? $item->content[2] : '')
    ->id($uniqid_02)->onclick('openCustomRoxy2(\'' . $uniqid_02 . '_frame\')')
    ->placholder('Click here to select a file.')
    !!}

    <div id="{{ $uniqid_02 }}_frame" style="display: none;">
        <iframe src="{{ url('/') }}/assets/admin/fileman/index.html?integration=custom&type=files&txtFieldId={{ $uniqid_02 }}" style="width:100%;height:100%" frameborder="0">
        </iframe>
    </div>

@endif