<div class="{{ $columnMixer($content) }} {{ $content->class }}" style="font-size: 0">
    @if(count($content->values))
    <video width="100%" height="auto" controls>
        @foreach($content->values as $video)
            @if(is_file(public_path($video->value)))
                <source src="{{ asset($video->value) }}" type="{{ file_mime(public_path($video->value)) }}">
            @endif
        @endforeach
        Your browser does not support the video tag.
        Consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>.
    </video>
    @endif
</div>