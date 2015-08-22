<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Helper</title>

    @if (app()->environment() != 'test')
        <link rel="stylesheet" href="{{ elixir3($assetsDirTheme . '/css/app.css', $buildPath) }}"/>
        <link rel="stylesheet" href="{{ elixir3($assetsDirTheme . '/css/all.css', $buildPath) }}"/>
        <link rel="stylesheet" href="{{ elixir3($assetsDirTheme . '/css/added.css', $buildPath) }}"/>
    @else
        <link rel="stylesheet" href="{{ elixir3($assetsDirTheme . '/css/all.pro.css', $buildPath) }}">
    @endif
</head>

<body class="{{ $bodyClass or '' }}">
<div id="loader"></div>
@yield('content')

@if(app()->environment() != 'test')
    <script src="{{ elixir3($assetsDirTheme . '/js/all.js', $buildPath) }}"></script>
    <script src="{{ elixir3($assetsDirTheme . '/js/added.js', $buildPath) }}"></script>
@else
    <script src="{{ elixir3($assetsDirTheme . '/js/all.pro.js', $buildPath) }}"></script>
@endif

@section('scripts_bottom')
@show

</body>
</html>
