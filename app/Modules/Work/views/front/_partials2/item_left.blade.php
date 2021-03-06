<div class="row clearfix match-height">
    <div class="col-xs-12 col-md-4">
        <h2 class="mar-b0">{{ $work->title }}</h2>

        <p class="lead">{{ $work->sub_title }}</p>

        <p> {{ $work->intro }}
            <br><a href="{{ route('work.index', $work->slug) }}" class="read-more red">Read more</a>
        </p>
    </div>
    <div class="col-xs-12 col-md-8">
        @if(count($work->images))
            <ul class="slider-box-left">
                @foreach($work->images as $image)
                    <li>
                        <img src="{{ asset('media/images/medium/' . $image->image) }}"
                             alt="{{ $image->alt }}" class="lazy">
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
