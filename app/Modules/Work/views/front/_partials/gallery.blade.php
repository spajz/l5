@if($content->sub_type == 'left')
<div class="row clearfix">
    <div class="col-xs-12 col-md-4">
        <p class="mar-text">
            {{ $content->content }}
        </p>
    </div>
    <div class="col-xs-12 col-md-8">
        @if(count($content->images))
            <div class="over-hidden">
                <img src="{{ asset('media/images/medium/' . $content->images[0]->image) }}"
                     alt="{{$content->images[0]->alt }}" class="lazy img-responsive grow">
            </div>
        @endif
    </div>
</div>
@else
<div class="row clearfix">
    <div class="col-xs-12 col-md-8">
        @if(count($content->images))
            <div class="over-hidden">
                <img src="{{ asset('media/images/medium/' . $content->images[0]->image) }}"
                     alt="{{$content->images[0]->alt }}" class="lazy img-responsive grow">
            </div>

        @endif
    </div>
    <div class="col-xs-12 col-md-4">
        <p class="mar-text">
            {{ $content->content }}
        </p>
    </div>
</div>
@endif