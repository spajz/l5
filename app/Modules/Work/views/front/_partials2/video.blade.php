@if($content->sub_type == 'left')
    <div class="row clearfix">
        <div class="col-xs-12 col-md-4">
            <p class="mar-text">
                @if(isset($content->content[0]))
                    {{ $content->content[0] }}
                @endif
            </p>
        </div>
        <div class="col-xs-12 col-md-8">
            @if(isset($content->content[1]))
                @include("work::front._partials.videojs_template", ['videoSrc' => asset($content->content[1])])
            @endif
        </div>
    </div>
@else
    <div class="row clearfix">
        <div class="col-xs-12 col-md-8">
            @if(isset($content->content[1]))
                @include("work::front._partials.videojs_template", ['videoSrc' => asset($content->content[1])])
            @endif
        </div>
        <div class="col-xs-12 col-md-4">
            <p class="mar-text">
                @if(isset($content->content[0]))
                    {{ $content->content[0] }}
                @endif
            </p>
        </div>
    </div>
@endif

