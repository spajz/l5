@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ trans('work::work.title') }}</h1>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <p>{{ trans('work::work.intro') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="spacer">

    <div class="container-fluid bor-t1">

        @if(count($works))

            @foreach($works as $k => $work)

                @if ($k & 1)

                    @include('work::front._partials.item_left', ['work' => $work])

                @else

                    @include('work::front._partials.item_right', ['work' => $work])

                @endif

            @endforeach

        @endif

    </div>

    @include('front::_partials.contact')

@stop

@section('scripts_bottom')
    @parent
    <script type="text/javascript">

        $(window).load(function(){
            $('.single-item').slick({
                autoplay: true,
                autoplaySpeed: 1000,
                fade: true,
                arrows: false,
                speed: 2000,
                waitForAnimate: false,
//                lazyLoad: 'progressive',
                pauseOnHover: true,
            });

            $('.single-item img').on('click', function (e) {
                $(this).closest('.single-item').slick('slickNext')
            });
        })

        $(window).on('load scroll', function (e) {
            $('.single-item').each(function(){
                if($(this).hasClass('slick-initialized')){
                    if($(this).is( ':in-viewport' )){
                        console.log($(this));
                        $(this).slick('slickPlay');
                    } else {
                        $(this).slick('slickPause');
                    }
                }
            })
        });
    </script>
@stop