<div class="row clearfix">
    <div class="col-xs-12 col-md-5">
        @if(isset($content->content[1]))
            @include("work::front._partials.videojs_template", ['videoSrc' => asset($content->content[1])])
        @endif
    </div>
    <div class="col-xs-12 col-md-2">
        <p class="mar-tb15">
            @if(isset($content->content[0]))
                {{ $content->content[0] }}
            @endif
        </p>
    </div>
    <div class="col-xs-12 col-md-5">
        @if(isset($content->content[2]))
            @include("work::front._partials.videojs_template", ['videoSrc' => asset($content->content[2])])
        @endif
    </div>
</div>

