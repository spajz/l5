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
                    <li><a href="#">Home</a></li>
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

    <div class="container-full">
        <div class="row clearfix">
            <div class="col-xs-12">
                <img src="{{ asset($assetsDirFront . '/images/slider.jpg') }}" width="100%">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row clearfix">
            <div class="col-xs-12">
                <h1 class="text-center red">Who We Are</h1>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-6 col-md-push-3">
                        <p class="text-center"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                            eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                            ullamco
                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit
                            in
                            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                            laborum.
                            <br><a href="#" class="read-more-red">More about us</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-cc-right bg-cc-bt">
        <div class="container">
            <div class="row clearfix match-height">
                <div class="col-xs-12 col-md-4">
                    <h2 class="mar-b0">Work 01</h2>

                    <p class="lead">Lorem ipsum dolor</p>

                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                        ullamco.

                        <br><a href="#" class="read-more-red">Read more</a>
                    </p>

                </div>
                <div class="col-xs-12 col-md-8 bg-cc">
                    &nbsp;
                </div>
            </div>
        </div>
    </div>

    <div class="bg-b3-left">
        <div class="container">
            <div class="row clearfix match-height">
                <div class="col-xs-12 col-md-8 bg-b3">
                    &nbsp;
                </div>
                <div class="col-xs-12 col-md-4">
                    <h2>Work 02</h2>

                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                        ullamco.
                        <br><a href="#" class="read-more-red">Read more</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts_bottom')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $('.match-height > div').matchHeight();
        })
    </script>
@stop