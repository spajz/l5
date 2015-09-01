<div class="row clearfix match-height">
    <div class="col-xs-12 col-md-4 col-md-push-8">
        <h2 class="mar-b0">{{ $work->title }}</h2>

        <p class="lead">{{ $work->sub_title }}</p>

        {!! $work->intro  !!}

        <p>
            <br><a href="{{ route('work.index', $work->slug) }}" class="read-more red">{{ trans('front::general.read_more') }}</a>
        </p>
    </div>
    <div class="col-xs-12 col-md-8 col-md-pull-4 box-left">
        @if(count($work->images))
            <div class="slider single-item">
                @foreach($work->images as $image)
                    <img src="{{ asset('media/images/medium/' . image_filename($image, 'medium')) }}"
                         alt="{{ $image->alt }}" class="zoom-1">
                @endforeach
            </div>
        @endif
    </div>
</div>
