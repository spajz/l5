@extends($layout)

@section('content')

    @include('front::_partials.navbar')

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ object_get($pages['ourWorks'], 'title') }}</h1>

                @if(object_get($pages['ourWorks'], 'description'))
                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <p>{{ object_get($pages['ourWorks'], 'description') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <hr class="spacer">

    <div class="container-fluid bor-t1">

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

    @include('front::_partials.contact')

@stop