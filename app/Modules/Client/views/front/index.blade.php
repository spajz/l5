@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ trans('client::client.title') }}</h1>
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <p>
                            {{ trans('client::client.intro') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="hr mar-tb15">

        <div class="row clearfix">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="row clearfix multi-columns-row">
                    @if(count($clients))
                        @foreach($clients as $client)
                            @if($imageUrl = image_url($client, $config))
                                <div class="col-xs-12 col-ms-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="ih-item square colored effect6 from_top_and_bottom">
                                        <a href="#" class="no-click" title="{{ $client->title }}">
                                            <div class="img">
                                                <img src="{{ asset($imageUrl) }}" alt="{{ $client->title }}" class="img-responsive">
                                            </div>
                                            <div class="info" style="@include('front::_partials.fcb_gradient', ['color' => $client->group->color])">
                                                <h3 style="color: {{ $client->group->text_color }}">{{ $client->title }}</h3>
                                                <p style="color: {{ $client->group->text_color }}">{{ $client->group->title }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>

    @include('front::_partials.contact')

@stop

@section('scripts_bottom')
    @parent
@stop

