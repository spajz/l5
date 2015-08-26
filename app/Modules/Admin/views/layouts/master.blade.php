<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel CMS</title>

    <meta name="description" content="CMS">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ Session::token() }}">

    @if (app()->environment() != 'test')
        <link rel="stylesheet" href="{{ elixir3($assetsDirAdmin . '/css/app.css', $buildPath) }}"/>
        <link rel="stylesheet" href="{{ elixir3($assetsDirAdmin . '/css/all.css', $buildPath) }}"/>
        <link rel="stylesheet" href="{{ elixir3($assetsDirAdmin . '/css/added.css', $buildPath) }}"/>
    @else
        <link rel="stylesheet" href="{{ elixir3($assetsDirAdmin . '/css/all.pro.css', $buildPath) }}">
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
<img src="{{ admin_asset('images/ajax.gif') }}" class="ajax-loader">

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">FCB Afirma CMS v2.0</a>
        </div>
        <!-- /.navbar-header -->

        @include("admin::_partials.top_menu")
        <!-- /.navbar-top-links -->

        @include("admin::_partials.sidebar")
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        @yield('content')
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

@if (app()->environment() != 'test')
    <script src="{{ elixir3($assetsDirAdmin . '/js/all.js', $buildPath) }}"></script>
    <script src="{{ elixir3($assetsDirAdmin . '/js/added.js', $buildPath) }}"></script>
@else
    <script src="{{ elixir3($assetsDirAdmin . '/js/all.pro.js', $buildPath) }}"></script>
@endif

<script src="{{ asset($assetsDirAdmin . '/vendor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset($assetsDirAdmin . '/vendor/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset($assetsDirAdmin . '/vendor/ckfinder/ckfinder.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#side-menu').metisMenu();
    });
</script>

@section('scripts_bottom')
@show

</body>
</html>