
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FCB</title>

    <meta name="description" content="">
    <meta name="author" content="">

    @if ( Config::get('app.debug') )
        <link rel="stylesheet" href="{{ asset($assetsDirFront . '/css/app.css') }}" />
        <link rel="stylesheet" href="{{ asset($assetsDirFront . '/css/all.css') }}" />
        <link rel="stylesheet" href="{{ asset($assetsDirFront . '/css/added.css') }}" />
    @else
        <link rel="stylesheet" href="{{ elixir($assetsDirFront . '/css/all.css') }}">
        <link rel="stylesheet" href="{{ elixir($assetsDirFront . '/css/added.css') }}">
    @endif

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @section('scripts_top')
    @show

</head>

<body role="document">

@yield('content')

@if ( Config::get('app.debug') )
    <script src="{{ asset("{$assetsDirFront}/js/all.js") }}"></script>
    <script src="{{ asset("{$assetsDirFront}/js/added.js") }}"></script>
@else
    <script src="{{ elixir("{$assetsDirFront}/js/all.js") }}"></script>
    <script src="{{ elixir("{$assetsDirFront}/js/added.js") }}"></script>
@endif

@section('scripts_bottom')
@show

</body>
</html>