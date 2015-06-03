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
                    PLUTOS COMPUTERS
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Početna</a></li>
                    <li><a href="#">Vesti</a></li>
                    <li><a href="#" class="active">Reference</a></li>
                    <li><a href="#">O nama</a></li>
                    <li><a href="#">Kontakt</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End fixed navbar -->

    <div class="container">

        <div class="row clearfix">

            <div class="col-md-3 col-lg-2 col-xs-12">

                <img src="{{ asset($assetsDirFront . '/images/logo.png') }}" alt="Logo" class="img-responsive logo">

                <h3 class="title">Kategorije</h3>

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
                                                    <a href="#">Link 4.2</a>
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

                <h3 class="title">Izdvajamo</h3>


            </div>

            <div class="col-md-9 col-lg-10 col-xs-12">

                <div class="owl-carousel" style="display: none;">
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


                <h1 class="title">Maticne ploce</h1>

                <div class="pagination-wrapper">
                    Sort by:
                </div>

                <div class="col-md-4 col-xs-12">
                    <div class="list-item">
                        <img src="{{ asset('media/slider/slider1.jpg') }}" class="img-responsive">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="list-item">
                        <img src="{{ asset('media/slider/slider2.jpg') }}" class="img-responsive">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="list-item">
                        <img src="{{ asset('media/slider/slider3.jpg') }}" class="img-responsive">
                    </div>
                </div>

                <div class="col-md-4 col-xs-12">
                    <div class="list-item">
                        <img src="{{ asset('media/slider/slider2.jpg') }}" class="img-responsive">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="list-item">
                        <img src="{{ asset('media/slider/slider3.jpg') }}" class="img-responsive">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="list-item">
                        <img src="{{ asset('media/slider/slider1.jpg') }}" class="img-responsive">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="list-item">
                        <img src="{{ asset('media/slider/slider2.jpg') }}" class="img-responsive">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="list-item">
                        <img src="{{ asset('media/slider/slider3.jpg') }}" class="img-responsive">
                    </div>
                </div>

                <div class="col-md-4 col-xs-12">
                    <div class="list-item">
                        <img src="{{ asset('media/slider/slider2.jpg') }}" class="img-responsive">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="list-item">
                        <img src="{{ asset('media/slider/slider3.jpg') }}" class="img-responsive">
                    </div>
                </div>


            </div>

        </div>

    </div>


    <footer>
        <div class="container">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="column">
                    <h4>Linkovi</h4>
                    <ul>
                        <li><a href="#">O nama</a></li>
                        <li><a href="#">Uslovi koriscenja</a></li>
                        <li><a href="#">Garancija</a></li>
                        <li><a href="#">Isporuka</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="column">
                    <h4>Radno vreme</h4>
                    <ul>
                        <li>Ponedeljak - petak: 9-17h</li>
                        <li>Subota: 10-14h</li>
                        <li>Nedelja: ne radimo</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="column">
                    <h4>Kontakt</h4>
                    <ul>
                        <li>Rada Koncara 27</li>
                        <li>Beograd, 11000</li>
                        <li>Telefon: +381 11 644 88 63</li>
                        <li>Email: office@plutos.rs</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="column">
                    <h4>Pratite nas i na</h4>
                    <ul class="social">
                        <li><a href="#">Google Plus</a></li>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">RSS Feed</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="navbar-inverse text-center copyright">
            Copyright &copy; 2015 Plutos computers
        </div>
    </footer>

@stop

@section('scripts_bottom')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $('.owl-carousel').owlCarousel();
        });

        $('#sidebar-nav ul').each(function () {
            var depth = $(this).parents('ul').length;
            $(this).addClass('level-' + depth);
            $(' > li > a', $(this)).css('padding-left', depth + 'em');
        });
    </script>
@stop