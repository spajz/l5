@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-full">
        <img src="{{ asset($assetsDirFront . '/images/slider.jpg') }}" width="100%">
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1 class="red">{{ object_get( $pages['whoWeAre'], 'title') }}</h1>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        {!! object_get($pages['whoWeAre'], 'description')  !!}
                        <p>
                            <br><a href="{{ route('person.index') }}" class="read-more red">{{ trans('front::general.more_about_us') }}</a>
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