@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ object_get($pages['ourWorks'], 'title') }}</h1>

                @if(object_get($pages['ourWorks'], 'description'))
                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <p>{{ object_get($pages['ourWorks'], 'description') }}</p>
                        </div>
                    </div>
                @endif
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

        $(window).load(function () {

            $('.single-item').slick({
                autoplay: true,
                autoplaySpeed: 1800,
                fade: true,
                arrows: false,
                speed: 1200,
                waitForAnimate: true,
                pauseOnHover: true,
            });

            $('.single-item img').on('click', function (e) {
                $(this).closest('.single-item').slick('slickNext')
            });
        })

        $(window).on('load scroll', function (e) {
            $('.single-item').each(function () {
                if ($(this).hasClass('slick-initialized')) {
                    if ($(this).is(':in-viewport')) {
                        $(this).slick('slickPlay');
                    } else {
                        $(this).slick('slickPause');
                    }
                }
            })
        });
    </script>
@stop