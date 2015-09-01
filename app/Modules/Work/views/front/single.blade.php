@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ $work->title }}</h1>
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        {!!  $work->description  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="spacer">

    <div class="container-fluid">

        <div class="row clearfix bor-t1">

            @if(count($work->contentable))

                @foreach($work->contentable as $content)

                    @if(view()->exists($includeView($content)))
                        @include($includeView($content), compact('content', 'columnMixer'))
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

