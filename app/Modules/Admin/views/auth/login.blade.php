@extends($layout)

@section('content')


<div class="container">

    <div class="row top20">
        <div class="col-xl-4 col-xl-offset-4 col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="text-center top5">
                        <img src="{{ asset($assetsDirAdmin . '/images/logo.png') }}">
                    </p>
                </div>
                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {!! Former::open()->route("admin.post.login")->method('post')->rules($validationRules) !!}

                        {!! Former::text('email')->label('E-Mail Address') !!}

                        {!! Former::password('password') !!}

                        {!! Former::checkbox('remember')->label('Remember Me') !!}

                        {!!
                            Former::actions(
                                Former::success_submit()->addClass(''),
                                Former::primary_reset()->addClass('reset-form')
                            )
                        !!}

                        <?php /*
                        <a href="/password/email">Forgot Your Password?</a>
                        */ ?>

                    {!! Former::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@stop