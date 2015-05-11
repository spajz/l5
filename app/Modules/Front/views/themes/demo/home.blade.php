@extends($layout)

@section('content')




    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="{{ asset($assetsDirFront . '/images/fcb-afirma-logo.png') }}" alt="FCB Afirma">
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Demo</a></li>
                    <li><a href="#">Who we are</a></li>
                    <li class="active"><a href="#">Our work</a></li>
                    <li><a href="#">Clients</a></li>
                    <li><a href="#">News</a></li>
                    <li><a href="#">Contact</a></li>
                    <li>
                        <a href="#" class="h0 border0">
                            <img src="{{ asset($assetsDirFront . '/images/social-but.png') }}" class="social-but">
                        </a>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">


        <div class="row clearfix">

            <div class="col-md-3 col-xs-12">





                <div class="panel panel-default">
                    <div class="panel-heading">CATEGORIES</div>
                    <div class="panel-body">
                        <nav id="sidebar-nav">
                            <ul class="nav">
                                <li>
                                    <a href="#">Link 1</a>
                                </li>
                                <li>
                                    <a href="#" data-toggle="collapse" data-target="#submenu1">
                                        Link 2 (toggle)
                                    </a>
                                    <ul class="nav collapse" id="submenu1" role="menu">
                                        <li><a href="#">Link 2.1</a></li>
                                        <li><a href="#">Link 2.2</a></li>
                                        <li>
                                            <a href="#" data-toggle="collapse" data-target="#submenu3">Link 2.3 ++</a>

                                            <ul class="nav collapse" id="submenu3" role="menu">
                                                <li><a href="#">Link 3.1</a></li>
                                                <li>
                                                    <a href="#" data-toggle="collapse" data-target="#submenu4">Link 4444 ++</a>

                                                    <ul class="nav collapse" id="submenu4" role="menu">
                                                        <li><a href="#">Link 4.1</a></li>
                                                        <li>
                                                            <a href="#">Link 4.2</a
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>

                                        </li>
                                    </ul>
                                </li>
                                <li><a href="#">Link 3</a></li>
                                <li><a href="#">Link 4</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>















             


            </div>


            <div class="col-md-9 col-xs-12">
                <div class="owl-carousel">
                    <div>
                        <img src="{{ asset('media/slider/slider1.jpg') }}">
                        <p>Slider 1</p>
                    </div>
                    <div>
                        <img src="{{ asset('media/slider/slider2.jpg') }}">
                        <p>Slider 2</p>
                    </div>
                    <div>
                        <img src="{{ asset('media/slider/slider3.jpg') }}">
                        <p>Slider 3</p>
                    </div>
                    <div>
                        <img src="{{ asset('media/slider/slider4.jpg') }}">
                        <p>Slider 4</p>
                    </div>
                    <div>
                        <img src="{{ asset('media/slider/slider5.jpg') }}">
                        <p>Slider 5</p>
                    </div>
                    <div>
                        <img src="{{ asset('media/slider/slider6.jpg') }}">
                        <p>Slider 6</p>
                    </div>

                </div>
            </div>
        </div>


        <div class="row clearfix">
            <div class="col-xs-12">
                <h1 class="text-center red">Who We Are</h1>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-4 col-md-push-4">
                        <p class="text-center"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                           labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                           laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                           voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                           cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop

@section('scripts_bottom')
@parent
    <script type="text/javascript">
        $(document).ready(function(){
            $('.owl-carousel').owlCarousel();
        });

        $('#sidebar-nav ul').each(function() {
            var depth = $(this).parents('ul').length;
            $(this).addClass('level-' + depth);
            $(' > li > a', $(this)).css('padding-left',  depth + 'em');
        });
    </script>
@stop