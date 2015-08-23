@extends($layout)

@section('content')



    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xs-12 text-center">
                <h1>Helper</h1>
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <p>
                            Helper
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="hr mar-tb15">

        <div class="row clearfix">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="row clearfix multi-columns-row">
                    @if(count($helpers))
                        @foreach($helpers as $helper)
                            <div class="col-xs-12 col-ms-6 col-sm-4 col-md-4 col-lg-3">
                                {{ $helper->title }}
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>



@stop

@section('scripts_bottom')
    @parent
@stop

