@extends($layout)

@section('content')

    <div id="info-box">{!! Notification::showAll() !!}</div>

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa fa-dashboard fa-fw"></i> Dashboard
            </h1>
        </div>
    </div>

@stop

@section('scripts_bottom')
    @parent

@stop