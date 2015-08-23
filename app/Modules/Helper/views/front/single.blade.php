@extends($layout)

@section('content')


    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>{{ $item->title }}</h1>
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <p>
                            {{ $item->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="hr mar-tb15">

        <div id="pjax-container">

            <div class="row clearfix">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="row clearfix multi-columns-row">
                        <div class="col-xs-12">
                            {!! $main !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


@stop

@section('scripts_bottom')
    @parent
@stop

