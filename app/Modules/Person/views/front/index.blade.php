@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ object_get($pages['ourPeople'], 'title') }}</h1>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        {!! object_get($pages['ourPeople'], 'description')  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="spacer">

    <div class="container-fluid person-container">
        <div class="person-wrap">
            <div class="row clearfix multi-columns-row persons-box">
                @if(count($persons))
                    @foreach($persons as $person)
                        @if($imageUrl = image_url($person, $config, 'medium'))

                            <div class="col-xs-6 col-ms-4 col-sm-4 col-md-3 col-lg-2 col-xl-7-1">
                                <div class="ih-item square colored effect14 left_to_right">
                                    <a href="#" class="person-btn">
                                        <div class="img">
                                            <img src="{{ module_asset('front', 'images/person350b.png') }}"  alt="{{ $person->title }}" class="img-responsive person-img"
                                                 style="background-image:url({{ asset($imageUrl) }}); background-position:0 0;">
                                        </div>
                                        <div
                                            class="info"
                                            style="@include('front::_partials.gradient', ['color' => $person->color])"
                                        >
                                            <div class="vertical-center">
                                                <h3 style="color: {{ $person->text_color }}">{{ $person->full_name }}</h3>
                                                <p class="lead" style="color: {{ $person->text_color }}">{{ $person->job_title }}</p>
                                                <p class="description" style="color: {{ $person->text_color }}">{{ $person->description }}</p>
                                            </div>
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

    @include('front::_partials.contact')

@stop

@section('scripts_bottom')
    @parent
@stop

