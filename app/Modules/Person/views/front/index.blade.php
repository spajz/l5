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

        <div class="row clearfix multi-columns-row persons-box">
            @if(count($persons))
                @foreach($persons as $person)
                    @if($imageUrl = image_url($person, $config, 'medium'))






                        <div class="col-xs-12 col-ms-6 col-sm-4 col-md-3 col-lg-2">




                            <!-- colored -->
                            <div class="ih-item square colored effect14 left_to_right">
                                <a href="#" class="person-btn">
                                    <div class="img">

                                        <img src="{{ module_asset('front', 'images/person300.png') }}"  alt="{{ $person->title }}" class="img-responsive person-img"
                                             style="background-image:url({{ asset($imageUrl) }}); background-position:0 0; background-size: 1000%;">

                                    </div>
                                    <div class="info" style="background-color: rgba({{ implode(',', hex2rgb($person->color)) }}, 1);">
                                        <h3 style="background-color: rgba({{ implode(',', hex2rgb($person->color)) }}, 1);">{{ $person->full_name }}</h3>
                                        <p>{{ $person->description }}</p>
                                    </div>
                                </a>
                            </div>
                            <!-- end colored -->



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

