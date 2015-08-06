@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ $work->title }}</h1>
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <p>
                            {{ $work->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="hr mar-tb15">

    </div>

    <div class="container-fluid">

        <div class="row clearfix multi-columns-row">

            @if(count($work->contentable))

                @foreach($work->contentable as $content)

                    @include('work::front._partials.' . $content->type . ($content->sub_type ? '_' . $content->sub_type: ''), compact('content'))

                @endforeach

            @endif
        </div>

    </div>

    @include('front::_partials.contact')

@stop

@section('scripts_bottom')
    @parent
@stop

