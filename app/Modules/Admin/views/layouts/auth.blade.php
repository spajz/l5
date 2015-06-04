<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CMS">
    <meta name="author" content="">

    <title>Laravel CMS</title>

    @if ( Config::get('app.debug') )
        <link rel="stylesheet" href="{{ elixir3($assetsDirAdmin . '/css/app.css', $buildPath) }}" />
        <link rel="stylesheet" href="{{ elixir3($assetsDirAdmin . '/css/all.css', $buildPath) }}" />
        <link rel="stylesheet" href="{{ elixir3($assetsDirAdmin . '/css/added.css', $buildPath) }}" />
    @else
        <link rel="stylesheet" href="{{ elixir3($assetsDirAdmin . '/css/all.css', $buildPath) }}">
    @endif

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        var baseUrl = "{{ url('/') }}";
        var baseUrlAdmin = "{{ url(ADMIN) }}";
    </script>

    @section('scripts_top')
    @show

</head>

<body>
<div id="info-box">{!! Notification::showAll() !!}</div>

<div id="wrapper">
    @yield('content')
</div>
<!-- /#wrapper -->

@if ( Config::get('app.debug') )
    <script src="{{ elixir3("{$assetsDirAdmin}/js/all.js", $buildPath) }}"></script>
    <script src="{{ elixir3("{$assetsDirAdmin}/js/added.js", $buildPath) }}"></script>
@else
    <script src="{{ elixir3("{$assetsDirAdmin}/js/all.js", $buildPath) }}"></script>
@endif

@section('scripts_bottom')
@show

</body>
</html>