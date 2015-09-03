@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-full">
        <div id="hero">
            <div class="slider-box">
                <img src="{{ asset($assetsDirFront . '/images/hero/hero-img-1500.png') }}" class="hero-bg-01">
                <img src="{{ asset($assetsDirFront . '/images/hero/creativity.png') }}" class="hero-creativity">
                <img src="{{ asset($assetsDirFront . '/images/hero/pobednik.png') }}" class="hero-pobednik">
            </div>
            <div class="slider-box">
                <img src="{{ asset($assetsDirFront . '/images/hero/hero-img-1500.png') }}" class="hero-bg-02">
                <img src="{{ asset($assetsDirFront . '/images/hero/baloni.png') }}" class="hero-baloni">
                {{--<img src="{{ asset($assetsDirFront . '/images/hero/konj.png') }}" class="hero-konj">--}}
            </div>
            <div class="slider-box">
                <img src="{{ asset($assetsDirFront . '/images/hero/hero-img-1500.png') }}" class="hero-bg-03">
                <img src="{{ asset($assetsDirFront . '/images/hero/change.png') }}" class="hero-change">
                {{--<img src="{{ asset($assetsDirFront . '/images/hero/hram.png') }}" class="hero-hram">--}}
            </div>
            <div class="slider-box">
                <img src="{{ asset($assetsDirFront . '/images/hero/hero-img-1500.png') }}" class="hero-bg-04">
                <img src="{{ asset($assetsDirFront . '/images/hero/ljuljaska.png') }}" class="hero-ljuljaska">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1 class="red">{{ object_get( $pages['whoWeAre'], 'title') }}</h1>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        {!! object_get($pages['whoWeAre'], 'description')  !!}
                        <p>
                            <br><a href="{{ route('person.index') }}"
                                   class="read-more red">{{ trans('front::general.more_about_us') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bor-tb1">

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

    <div class="bg-03">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 text-center">
                    <h1>{{ object_get($pages['ourClients'], 'title') }}</h1>

                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            {!! object_get($pages['ourClients'], 'description') !!}
                            <p>
                                <br><a href="{{ route('client.index') }}"
                                       class="read-more">{{ trans('front::general.see_the_logos') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('front::_partials.contact')

@stop

@section('scripts_top')
    @parent
    <style type="text/css">
        .slider-box {
            position: relative;
            /*height: 700px;*/
        }

        .slider-box img {
            position: absolute;
            width: 100%;
            height: auto;
        }

        .hero-creativity{
            opacity: 0;
        }

        .hero-bg-01{
            background: url({{ asset($assetsDirFront . '/images/hero/hero-bg.jpg') }}) no-repeat 0 0;
            -webkit-background-size: auto 100%;
            -moz-background-size: auto 100%;
            -o-background-size: auto 100%;
            background-size: auto 100%;
        }

        .hero-bg-02{
            background: url({{ asset($assetsDirFront . '/images/hero/hero-bg.jpg') }}) no-repeat 33.33333% 0;
            -webkit-background-size: auto 100%;
            -moz-background-size: auto 100%;
            -o-background-size: auto 100%;
            background-size: auto 100%;
        }

        .hero-bg-03{
            background: url({{ asset($assetsDirFront . '/images/hero/hero-bg.jpg') }}) no-repeat 50% 0;
            -webkit-background-size: auto 100%;
            -moz-background-size: auto 100%;
            -o-background-size: auto 100%;
            background-size: auto 100%;
        }

        .hero-bg-04{
            background: url({{ asset($assetsDirFront . '/images/hero/hero-bg.jpg') }}) no-repeat 100% 0;
            -webkit-background-size: auto 100%;
            -moz-background-size: auto 100%;
            -o-background-size: auto 100%;
            background-size: auto 100%;
        }

    </style>
@stop

@section('scripts_bottom')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {

            function animateBg(a) {
                a = typeof a !== 'undefined' ? a : 1;
                var percent = a * 100;
                $('#hero-img-01').animate({
                    'background-position-x': percent + '%',
                }, 40000, 'linear', function () {
                    a++;
                    animateBg(a);
                });
            }

            function animateBg2(a) {
                a = typeof a !== 'undefined' ? a : 1;
                var percent = a * 100;
                $('#hero-img-02').animate({
                    'background-position-x': percent + '%',
                }, 25000, 'linear', function () {
                    a++;
                    animateBg2(a);
                });
            }
        })

        $(window).on('load', function(){


            var h = $('.slider-box').find('img').first().height();

            $('.slider-box').height(h);

            $('#hero').slick({
                autoplay: false,
                autoplaySpeed: 4000,
                fade: false,
                arrows: false,
                speed: 1000,
                waitForAnimate: true,
                pauseOnHover: false,
            });


            $('#hero img').on('click', function (e) {
                $(this).closest('#hero').slick('slickNext')
            });



            $('.hero-pobednik').velocity({
                left: "-=5%",
            }, {
//                loop: 4,
                /* Wait 100ms before alternating back. */
//                delay: 300,
                duration: 4000,
                easing: 'linear',
            });

            $('.hero-creativity').velocity({
                right: "-=5%",
                opacity: 1,
//                width: "+=5rem", // Add 5rem to the current rem value
//                height: "*=2" // Double the current height
            }, {
                easing: 'linear',
                duration: 2000,
            }).velocity({
                        right: "-=5%",
                        opacity: 0,
//                width: "+=5rem", // Add 5rem to the current rem value
//                height: "*=2" // Double the current height
                    }, {
                        easing: 'linear',
                        duration: 2000,
                    });
        })
    </script>
@stop