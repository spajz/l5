@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ object_get($pages['whereWeAre'], 'title') }}</h1>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        {!! object_get($pages['whereWeAre'], 'description')  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="spacer">

    <div class="container-full">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2830.0099517632366!2d20.463819200000007!3d44.8213619!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a7ab5b3e3ddeb%3A0xd966ef19af20bf4d!2s42+Cara+Du%C5%A1ana%2C+Beograd+11000!5e0!3m2!1sen!2srs!4v1431430649436"
                width="100%" height="100%" frameborder="0" style="border:0" id="google-map">
        </iframe>
    </div>

    @include('front::_partials.contact')

@stop

@section('scripts_bottom')
    @parent
@stop