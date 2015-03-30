@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }} List
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
           <p><a href="#" class="btn btn-primary dt-clear">Clear</a> </p>
        </div>
    </div>

    {!! $dtTable !!}

@stop

@section('scripts_bottom')
    @parent

    {!! $dtJavascript !!}

@stop