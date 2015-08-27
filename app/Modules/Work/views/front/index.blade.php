@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ trans('client::client.clients') }}</h1>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <p>{{ trans('client::client.intro') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="hr mar-tb15">

    </div>

    <div class="container-fluid">

        @if(count($works))

            @foreach($works as $k => $work)

                @if ($k & 1)

                    @include('work::front._partials.item_right', ['work' => $work])

                @else

                    @include('work::front._partials.item_left', ['work' => $work])

                @endif

            @endforeach

        @endif

    </div>

    @include('front::_partials.contact')

@stop

@section('scripts_bottom')
    @parent
    <script type="text/javascript">


        $('.single-item').slick({
            autoplay: true,
            fade: true,
            arrows: false,
            speed: 2000,
            waitForAnimate: false,
        });

        $('.single-item img').on('click', function (e) {
            $(this).closest('.single-item').slick('slickNext')
        });

//        $('.single-item img').hoverIntent({
//            over: function(){
//                $(this).addClass('zoom-1');
//            },
//            out: function(){
//                $(this).removeClass('zoom-1');
//            },
//        });


        $('.slider-box-left').slippry({
            // general elements & wrapper
            slippryWrapper: '<div class="sy-box pictures-slider" />', // wrapper to wrap everything, including pager

            // options
            adaptiveHeight: false, // height of the sliders adapts to current slide
            captions: false, // Position: overlay, below, custom, false

            // pager
            pager: false,

            // controls
            controls: false,
            autoHover: false,

            // transitions
            transition: 'kenburns', // fade, horizontal, kenburns, false
            kenZoom: 120,
            speed: 2500 // time the transition takes (ms)
        });

        $('.slider-box-right').slippry({
            // general elements & wrapper
            slippryWrapper: '<div class="sy-box pictures-slider" />', // wrapper to wrap everything, including pager

            // options
            adaptiveHeight: false, // height of the sliders adapts to current slide
            captions: false, // Position: overlay, below, custom, false

            // pager
            pager: false,

            // controls
            controls: false,
            autoHover: false,

            autoDelay: 1300,

            // transitions
            transition: 'kenburns', // fade, horizontal, kenburns, false
            kenZoom: 100,
            speed: 3000 // time the transition takes (ms)
        });


    </script>
@stop