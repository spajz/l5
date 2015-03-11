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
        <link rel="stylesheet" href="{{ asset($assetsDir . '/css/all.css') }}" />
        <link rel="stylesheet" href="{{ asset($assetsDir . '/css/added.css') }}" />
    @else
        <link rel="stylesheet" href="{{ elixir($assetsDir . '/css/all.css') }}">
        <link rel="stylesheet" href="{{ elixir($assetsDir . '/css/added.css') }}">
    @endif

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

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
            <a class="navbar-brand" href="index.html">SB Admin v2.0</a>
        </div>
        <!-- /.navbar-header -->

        @include("{$viewPath}._partials.topmenu")
        <!-- /.navbar-top-links -->

        @include("{$viewPath}._partials.sidebar")
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        @yield('content')
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

@if ( Config::get('app.debug') )
    <script src="{{ asset("{$assetsDir}/js/all.js") }}"></script>
    <script src="{{ asset("{$assetsDir}/js/added.js") }}"></script>
@else
    <script src="{{ elixir("{$assetsDir}/js/all.js") }}"></script>
    <script src="{{ elixir("{$assetsDir}/js/added.js") }}"></script>
@endif

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });

        $('#side-menu').metisMenu();
    });
</script>

</body>

</html>
