<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FCB</title>

    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{{ session()->token() }}}">

    @if (app()->environment() != 'test')
        <link rel="stylesheet" href="{{ elixir3($assetsDirFront . '/css/app.css', $buildPath) }}" />
        <link rel="stylesheet" href="{{ elixir3($assetsDirFront . '/css/all.css', $buildPath) }}" />
        <link rel="stylesheet" href="{{ elixir3($assetsDirFront . '/css/added.css', $buildPath) }}" />
    @else
        <link rel="stylesheet" href="{{ elixir3($assetsDirFront . '/css/all.css', $buildPath) }}">
        <link rel="stylesheet" href="{{ elixir3($assetsDirFront . '/css/added.css', $buildPath) }}">
        @endif

                <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    @section('scripts_top')
    @show
    <script type="text/javascript">var baseUrl = '{{ url('/') }}';</script>
</head>

<body class="{{ $bodyClass or '' }}">
<div id="loader"></div>
@yield('content')

@if(app()->environment() != 'test')
    <script src="{{ elixir3("{$assetsDirFront}/js/all.js", $buildPath) }}"></script>
    <script src="{{ elixir3("{$assetsDirFront}/js/added.js", $buildPath) }}"></script>
@else
    <script src="{{ elixir3("{$assetsDirFront}/js/all.js", $buildPath) }}"></script>
    <script src="{{ elixir3("{$assetsDirFront}/js/added.js", $buildPath) }}"></script>
@endif

@section('scripts_bottom')
@show

<div class="viewports">
    <div class="visible-xs"></div>
    <div class="visible-ms"></div>
    <div class="visible-sm"></div>
    <div class="visible-md"></div>
    <div class="visible-lg"></div>
</div>

<script>
    videojs.options.flash.swf = "{{ asset("{$assetsDirFront}/js/video-js.swf") }}";
</script>

</body>
</html>