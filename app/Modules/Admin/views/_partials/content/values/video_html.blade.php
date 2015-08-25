@if(is_file(public_path($video->value)))
    <a href="#{{ md5($video->value) }}" class="btn btn-success btn-xs fancybox">Preview video</a>
    <div id="{{ md5($video->value) }}" style="display: none;">
        <video width="960" height="540" controls>
            <source src="{{ asset($video->value) }}" type="{{ file_mime(public_path($video->value)) }}">
            Your browser does not support the video tag.
        </video>
    </div>
@else
    File does not exist or has been removed.
@endif
