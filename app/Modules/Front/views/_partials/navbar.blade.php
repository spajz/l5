<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top bor-b1">
    <div class="container" id="top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset($assetsDirFront . '/images/fcb-afirma-logo.png') }}" alt="FCB Afirma">
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('home') }}">{{ trans('front::menu.home') }}</a></li>
                <li><a href="{{ route('person.index') }}">{{ trans('front::menu.who_we_are') }}</a></li>
                <li><a href="{{ route('work.index') }}">{{ trans('front::menu.our_work') }}</a></li>
                <li><a href="{{ route('client.index') }}">{{ trans('front::menu.our_clients') }}</a></li>
                <li><a href="{{ route('contact') }}">{{ trans('front::menu.contact') }}</a></li>

                <li class="lang-but-wrap">
                    @if($countItems = count(config('front.languages')))
                        @foreach(config('front.languages') as $code => $language)
                            <a
                                @if(app()->getLocale() == $code)
                                    class="active"
                                @endif
                                href="{{LaravelLocalization::getLocalizedURL($code) }}"
                            >{{ $code }}</a>
                            <?php
                                $countItems--;
                                if($countItems>0) echo '/';
                            ?>
                        @endforeach
                    @endif
                </li>
                <?php /*
                <li>
                    <a href="#" class="h0 border0">
                        <img src="{{ asset($assetsDirFront . '/images/social-but.png') }}" class="social-but">
                    </a>
                </li>
                */ ?>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>