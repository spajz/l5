
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Demo</title>

    <meta name="description" content="">
    <meta name="author" content="">

    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400italic,700italic,400,300,700|Roboto:400,400italic,700' rel='stylesheet' type='text/css'>

    @if ( Config::get('app.debug') )
        <link rel="stylesheet" href="{{ asset($assetsDirFront . '/css/app.demo.css') }}" />
        <link rel="stylesheet" href="{{ asset($assetsDirFront . '/css/all.demo.css') }}" />
        <link rel="stylesheet" href="{{ asset($assetsDirFront . '/css/added.demo.css') }}" />
    @else
        <link rel="stylesheet" href="{{ elixir2($assetsDirFront . '/css/all.demo.css', $buildPath) }}">
        <link rel="stylesheet" href="{{ elixir2($assetsDirFront . '/css/added.demo.css', $buildPath) }}">
    @endif

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @section('scripts_top')
    @show

</head>

<body>

@yield('content')

@if ( Config::get('app.debug') )
    <script src="{{ asset("{$assetsDirFront}/js/all.demo.js") }}"></script>
    <script src="{{ asset("{$assetsDirFront}/js/added.demo.js") }}"></script>
@else
    <script src="{{ elixir2("{$assetsDirFront}/js/all.demo.js", $buildPath) }}"></script>
    <script src="{{ elixir2("{$assetsDirFront}/js/added.demo.js", $buildPath) }}"></script>
@endif

@section('scripts_bottom')
@show

</body>
</html>