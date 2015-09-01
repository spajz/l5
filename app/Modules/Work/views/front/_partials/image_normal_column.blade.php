<?php
$localConfig = get_content_config("{$moduleLower}.content.element.{$content->type}");
?>
<div class="{{ $columnMixer($content) }} {{ $content->class }}">
    @if(count($content->images) && is_file(image_path($content, $localConfig, $size = 'large')))
        <div class="over-hidden">
            <img src="{{ asset('media/images/large/' . image_filename($content->images[0], 'large')) }}" alt="" class="img-responsive zoom-2">
        </div>
    @endif
</div>