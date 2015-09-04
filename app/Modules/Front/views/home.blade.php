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
                <img src="{{ asset($assetsDirFront . '/images/hero/konj.png') }}" class="hero-konj">
            </div>
            <div class="slider-box">
                <img src="{{ asset($assetsDirFront . '/images/hero/hero-img-1500.png') }}" class="hero-bg-03">
                <img src="{{ asset($assetsDirFront . '/images/hero/change.png') }}" class="hero-change">
                <img src="{{ asset($assetsDirFront . '/images/hero/hram.png') }}" class="hero-hram">
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

        .hero-creativity {
            opacity: 0;
        }

        .hero-baloni {
            opacity: 0;
        }

        .hero-change {
            opacity: 0;
        }

        .hero-bg-01 {
            background: url({{ asset($assetsDirFront . '/images/hero/hero-bg.jpg') }}) no-repeat 0 0;
            -webkit-background-size: auto 100%;
            -moz-background-size: auto 100%;
            -o-background-size: auto 100%;
            background-size: auto 100%;
        }

        .hero-bg-02 {
            background: url({{ asset($assetsDirFront . '/images/hero/hero-bg.jpg') }}) no-repeat 33.33333% 0;
            -webkit-background-size: auto 100%;
            -moz-background-size: auto 100%;
            -o-background-size: auto 100%;
            background-size: auto 100%;
        }

        .hero-bg-03 {
            background: url({{ asset($assetsDirFront . '/images/hero/hero-bg.jpg') }}) no-repeat 50% 0;
            -webkit-background-size: auto 100%;
            -moz-background-size: auto 100%;
            -o-background-size: auto 100%;
            background-size: auto 100%;
        }

        .hero-bg-04 {
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

        $(window).on('load', function () {


            var h = $('.slider-box').find('img').first().height();

            $('.slider-box').height(h);

            $('#hero').slick({
                autoplay: true,
                autoplaySpeed: 4000,
                fade: false,
                arrows: false,
                speed: 1500,
                waitForAnimate: true,
                pauseOnHover: false,
            });

            $('#hero img').on('click', function (e) {
                $(this).closest('#hero').slick('slickNext')
            });

            $('#hero').on('afterChange', function (event, slick, currentSlide, nextSlide) {
                console.log(currentSlide);
                if (currentSlide == 0) {
                    $.Velocity.RunSequence(sequnce01);
                }
                if (currentSlide == 1) {
                    $.Velocity.RunSequence(sequnce02);
                }
                if (currentSlide == 2) {
                    $.Velocity.RunSequence(sequnce03);
                }
                if (currentSlide == 3) {
                    $.Velocity.RunSequence(sequnce04);
                }

            });

            function resetProperties(properties) {
                $.each(properties, function (index, value) {
                    $(value).attr("style", "");
                });
            }

            var sequnce01 = [
                {
                    e: $('.hero-pobednik'),
                    p: {left: "-=7%"},
                    o: {
                        duration: 4000,
                        easing: 'linear',
                        sequenceQueue: false
                    }
                },
                {
                    e: $('.hero-creativity'),
                    p: {
                        right: "-=5%",
                        opacity: 1,
                    },
                    o: {
                        easing: 'linear',
                        duration: 2000,
                        sequenceQueue: false
                    }
                },
                {
                    e: $('.hero-creativity'),
                    p: {
                        right: "-=5%",
                        opacity: 0,
                    },
                    o: {
                        easing: 'linear',
                        duration: 2000,
                        complete: function () {
                            setTimeout(function () {
                                resetProperties(['.hero-pobednik', '.hero-creativity']);
                            }, 1000);
                        }
                    }
                },
            ];

            $.Velocity.RunSequence(sequnce01);

            var sequnce02 = [

                {
                    e: $('.hero-konj'),
                    p: {left: "+=7%"},
                    o: {
                        duration: 4000,
                        easing: 'linear',
                        sequenceQueue: false
                    }
                },
                {
                    e: $('.hero-baloni'),
                    p: {
                        top: "-=15%",
                        opacity: 1,
                    },
                    o: {
                        easing: 'linear',
                        duration: 1330,
                        sequenceQueue: false
                    }
                },
                {
                    e: $('.hero-baloni'),
                    p: {
                        top: "-=15%",
                    },
                    o: {
                        easing: 'linear',
                        duration: 1330,
                    }
                },
                {
                    e: $('.hero-baloni'),
                    p: {
                        top: "-=15%",
                        opacity: 0,
                    },
                    o: {
                        easing: 'linear',
                        duration: 1330,
                        complete: function () {
                            setTimeout(function () {
                                resetProperties(['.hero-konj', '.hero-baloni']);
                            }, 1000);
                        }
                    }
                },
            ];

            var sequnce03 = [
                {
                    e: $('.hero-hram'),
                    p: {left: "-=7%"},
                    o: {
                        duration: 4000,
                        easing: 'linear',
                        sequenceQueue: false
                    }
                },
                {
                    e: $('.hero-change'),
                    p: {
                        scale: 0.3,
                    },
                    o: {
                        duration: 300,
                        sequenceQueue: false
                    }
                },
                {
                    e: $('.hero-change'),
                    p: {
                        scale: 1,
                        opacity: 1,
                    },
                    o: {
                        easing: 'easeInQuad',
                        duration: 3700,
                        complete: function () {
                            setTimeout(function () {
                                resetProperties(['.hero-hram']);
                            }, 1000);
                            setTimeout(function () {
                                $('.hero-change').css({
                                    opacity: 0,
                                    transform: 'scale(0.3)'
                                });
                            }, 1000);
                        }
                    }
                },
            ];

            var sequnce04 = [
                {
                    e: $('.hero-ljuljaska'),
                    p: {left: "-=10%"},
                    o: {
                        duration: 1000,
                        loop: 2,
                        easing: 'easeInOutQuad',
                        complete: function () {
                            setTimeout(function () {
                                resetProperties(['.hero-ljuljaska']);
                            }, 1000);
                        }
                    }
                },
            ];


//            $('.hero-bg-01').velocity({
//                'background-position-x': ['-150px', '0px']
//            }, {
//                duration: 4000,
//                easing: 'linear',
//            });

//            $('.hero-pobednik').velocity({
//                left: "-=5%",
//            }, {
//                duration: 4000,
//                easing: 'linear',
//            });

//            $('.hero-creativity').velocity({
//                right: "-=5%",
//                opacity: 1,
//            }, {
//                easing: 'linear',
//                duration: 2000,
//            }).velocity({
//                right: "-=5%",
//                opacity: 0,
//            }, {
//                easing: 'linear',
//                duration: 2000,
//            });
        })
    </script>
@stop