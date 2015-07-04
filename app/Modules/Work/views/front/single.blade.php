@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ $work->title }}</h1>
                <p class="lead">{{ $work->sub_title }}</p>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <p>{!! $work->description !!}</p>
                    </div>
                </div>

            </div>
        </div>

        <hr class="hr mar-tb15">

    </div>

    <div class="container-fluid">

    @if(count($work->contentable))

        @foreach($work->contentable as $k => $content)

                @include('work::front._partials.' . $content->type, ['content' => $content])

        @endforeach

    @endif

    </div>

    @include('front::_partials.contact')

@stop

@section('scripts_bottom')
    @parent
@stop