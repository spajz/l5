<?php
$colors = [
        '#41305f',
        '#3e3149',
        '#3f3050',
        '#3d385d',
        '#364865',
        '#324f84',
        '#355081',
        '#324d34',
        '#227136',
        '#247F3A',
        '#507938',
        '#7E402B',
        '#D1382B',
        '#C23628',
        '#E2342B',
        '#DF712C',
        '#CA3C2A',
        '#F3982D',
        '#F7A92B',
        '#EB722D',
        '#F1942D',
        '#E2342B',
        '#C53729',
        '#D7372B',
        '#DE562C',
        '#D34E2D',
        '#ED852C',
        '#A83929',
        '#832F24',
        '#DE312B',
        '#BA2F28',
        '#E7612C',
        '#E33C2C',
        '#DB342E',
        '#CA303A',
        '#DD305D',
        '#B12B58',
        '#DE306B',
        '#DC346D',
        '#B32E43',
        '#BF2F50',
        '#B52C2F',
        '#BA2F2C',
        '#CE302C',
        '#A22B25',
        '#822621',
        '#84282D',
        '#5E2751',
        '#3E2253',
        '#392558',
];

/*
background: rgba(255,255,255,1);
background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(0,0,0,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(255,255,255,1)), color-stop(100%, rgba(0,0,0,1)));
background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(0,0,0,1) 100%);
background: -o-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(0,0,0,1) 100%);
background: -ms-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(0,0,0,1) 100%);
background: linear-gradient(to bottom, rgba(255,255,255,1) 0%, rgba(0,0,0,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#000000', GradientType=0 );
*/

//color_brightness('#7E913C', 255)
?>
<div class="fcb-pattern-wrap" xmlns="http://www.w3.org/1999/html">
    <div class="fcb-pattern">
        @foreach($colors as $color)
            <div class="color-cell" style="@include('front::_partials.fcb_gradient', ['color' => $color])">&nbsp;</div>
        @endforeach
    </div>
    <?php /*
    <button type="button" class="btn drpiga-btn btn-xs pattern-btn">Nemoj da klikneš ovde!</button>
    */ ?>
</div>
<div class="my-pattern-wrap" style="display: none">
    <div class="my-pattern sortable" id="items">
        @foreach($colors as $color)
            <div class="color-cell" data-color="{{ $color }}" id="qweqwe"
                 style="@include('front::_partials.my_gradient', ['color' => $color])">
                <a href="#" class="remove-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a><br>

                <a href="#" class="add-btn"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

                <input type="hidden" id="hidden-input" class="minicolors" value="{{ $color }}">

            </div>
        @endforeach
    </div>


    <form class="colors-form">
        <div class="col-xs-12">
            <input type="text" class="form-control colors-text"
                   placeholder="Ti sigurno nećeš da ne upišeš nešto.">
        </div>
        <div class="col-xs-6">
            <select class="form-control">
                <option>Akcije su ovde...</option>
                <option>Obrisi sve</option>
                <option>Vrati FCB boje</option>
                <option>Snimi i izadji</option>
                <option>Podeli na Facebook, i videces i druge</option>
            </select>
        </div>
        <div class="col-xs-6">
            <button type="button" class="btn btn-primary">Podeli i pogledaj druge</button>
        </div>
    </form>
</div>

@section('scripts_bottom')
    @parent
    <script type="text/javascript">

        function setGradient(color, elem) {

            var rgb1 = rgbToStr(hexToRgb(color));
            var color2 = colorLuminance(color, -0.2);
            var rgb2 = rgbToStr(hexToRgb(color2));

            console.log(rgb1);
            console.log(rgb2);
            console.log(color2);

            elem.css("background-image", "rgba(" + rgb1 + ",1)");
            elem.css("background-image", " -moz-linear-gradient(top, rgba(" + rgb1 + ",0.9) 0%, rgba(" + rgb2 + ",1) 50%)");
            elem.css("background-image", "-webkit-gradient(left top, left bottom, color-stop(0%, rgba(" + rgb1 + ",0.9)), color-stop(50%, rgba(" + rgb2 + ",1)))");
            elem.css("background-image", "-webkit-linear-gradient(top, rgba(" + rgb1 + ",0.9) 0%, rgba(" + rgb2 + ",1) 50%)");
            elem.css("background-image", "-o-linear-gradient(top, rgba(" + rgb1 + ",0.9) 0%, rgba(" + rgb2 + ",1) 50%)");
            elem.css("background-image", "-ms-linear-gradient(top, rgba(" + rgb1 + ",0.9) 0%, rgba(" + rgb2 + ",1) 50%)");
            elem.css("background-image", "linear-gradient(to bottom, rgba(" + rgb1 + ",0.9) 0%, rgba(" + rgb2 + ",1) 50%)");
        }


        $(document).ready(function () {
            $('.pattern-btn').on('click', function () {
                $('.my-pattern-wrap').slideToggle();
            })
            $('.my-pattern .remove-btn').on('click', function () {
                $(this).parent().remove();
            })

//            $('.sortable').sortable();

//            var el =  $('.sortable');
//            var sortable = Sortable.create($('.sortable'));

            $('.sortable').sortable({});

            $('.minicolors').minicolors({
                change: function (hex) {
                    setGradient(hex, $(this).closest('.color-cell'));
                }
            });

            $('.add-btn').minicolors({

            })


        })

        function colorLuminance(hex, lum) {

            // validate hex string
            hex = String(hex).replace(/[^0-9a-f]/gi, '');
            if (hex.length < 6) {
                hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
            }
            lum = lum || 0;

            // convert to decimal and change luminosity
            var rgb = "#", c, i;
            for (i = 0; i < 3; i++) {
                c = parseInt(hex.substr(i * 2, 2), 16);
                c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
                rgb += ("00" + c).substr(c.length);
            }

            return rgb;
        }

        function hexToRgb(hex) {
            // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
            var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
            hex = hex.replace(shorthandRegex, function (m, r, g, b) {
                return r + r + g + g + b + b;
            });

            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        }

        function rgbToStr(obj) {
            return obj.r + ',' + obj.g + ',' + obj.b;
        }

    </script>
@stop
