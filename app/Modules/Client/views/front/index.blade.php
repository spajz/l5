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

        <div class="row clearfix">
            <div class="col-xs-12 col-md-offset-3 col-md-6">

                <div class="row clearfix">
                    @if(count($clients))
                        @foreach($clients as $client)
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                <img src="{{ asset('media/images/thumb/' . $client->images[0]->image) }}"
                                     alt="{{ $client->title }}" class="img-responsive mar-center">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('front::_partials.contact')

@stop