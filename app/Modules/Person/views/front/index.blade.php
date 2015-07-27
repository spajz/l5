@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ trans('person::person.title') }}</h1>
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <p>
                            {{ trans('person::person.intro') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="hr mar-tb15">

        <div class="row clearfix multi-columns-row">
            @if(count($persons))
                @foreach($persons as $person)
                    @if($imageUrl = image_url($person, $config))
                        <div class="col-xs-12 col-ms-6 col-sm-4 col-md-3 col-lg-2">
                            <img src="{{ asset($imageUrl) }}" alt="{{ $person->title }}" class="img-responsive">
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

    </div>

    @include('front::_partials.contact')

@stop

@section('scripts_bottom')
    @parent
@stop

