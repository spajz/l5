<div id="contact">
    <div class="container-fluid">
        <div class="row clearfix bor-t1">
            <div class="col-xs-12 text-center">
                <a href="#top" class="read-more red scroll-btn">{{ trans('front::general.back_to_top') }}</a>
            </div>
            <div class="col-xs-12 col-sm-3">
                <p class="big"><b>Cara Dušana 42,</b><br>
                    11000 {{ trans('front::general.belgrade') }},<br>
                    {{ trans('front::general.serbia') }}
                </p>
            </div>
            <div class="col-xs-12 col-sm-3">
                <p class="big"><b>{{ trans('front::general.contact') }}:</b><br>
                    T +381 11 3284 620<br>
                    office&#64;fcbafirma.rs
                </p>
            </div>
            <div class="col-xs-12 col-sm-3">
                &nbsp;
            </div>
            <div class="col-xs-12 col-sm-3 text-right">
                <p class="big"><b>Feeling social?</b><br>
                    <a href="https://www.facebook.com/fcbafirma" title="Facebook" target="_blank">
                        <img src="{{ asset($assetsDirFront . '/images/facebook.png') }}" alt="Facebook">
                    </a>

                    <a href="https://twitter.com/fcb_afirma" title="Twitter" target="_blank">
                        <img src="{{ asset($assetsDirFront . '/images/twitter.png') }}" alt="Twitter">
                    </a>

                    <a href="https://instagram.com/explore/tags/fcbafirma/" title="Instagram" target="_blank">
                        <img src="{{ asset($assetsDirFront . '/images/instagram.png') }}" alt="Instagram">
                    </a>
                </p>
            </div>
        </div>
    </div>
    @include('front::_partials.fcb_pattern')
</div>
<?php /*
<div class="fcb-line">
    <img src="{{ asset($assetsDirFront . '/images/fcb-line.jpg') }}" width="100%">
</div> */ ?>
