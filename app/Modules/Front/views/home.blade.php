@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-full">
        <img src="{{ asset($assetsDirFront . '/images/slider.jpg') }}" width="100%">
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1 class="red">{{ trans('front::home.who_we_are') }}</h1>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <p>{!! trans('front::home.intro') !!}
                            <br><a href="#" class="read-more red">More about us</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-03">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 text-center">
                    <h1>Our Clients</h1>

                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <p> {{ trans('client::client.intro') }}
                                <br><a href="{{ route('client.index') }}" class="read-more">See the logos</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('front::_partials.contact')

@stop

@section('scripts_bottom')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $('.match-height > div').matchHeight();
        })
    </script>
@stop