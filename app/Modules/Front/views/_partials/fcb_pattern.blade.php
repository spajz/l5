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
        <div class="color-cell cell-template" data-color="#ffffff"
             style="@include('front::_partials.my_gradient', ['color' => '#ffffff'])">
            <a href="#" class="remove-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a><br>
            <a href="#" class="add-btn"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a><br>
            <a href="#" class="replace-btn"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span></a>
        </div>
        @foreach($colors as $color)
            <div class="color-cell" data-color="{{ $color }}"
                 style="@include('front::_partials.my_gradient', ['color' => $color])">
                <a href="#" class="remove-btn"><span class="glyphicon glyphicon-remove"
                                                     aria-hidden="true"></span></a><br>
                <a href="#" class="add-btn"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a><br>
                <a href="#" class="replace-btn"><span class="glyphicon glyphicon-repeat"
                                                      aria-hidden="true"></span></a><br>
                <input type="checkbox" class="color-selector">
            </div>
        @endforeach
    </div>

    <form class="colors-form">
        <div class="col-xs-12">
            <input type="text" class="form-control colors-text"
                   placeholder="Ti sigurno nećeš da ne upišeš nešto.">
        </div>
        <div class="col-xs-6">
            <select class="form-control pattern-actions">
                <option>Akcije su ovde...</option>
                <option value="1">Obrisi sve</option>
                <option value="2">Obrisi selektovane</option>
                <option value="3">Vrati FCB boje</option>
                <option value="4">Uradi prelaz izmedju 2 selektovane boje</option>
                <option value="5">Snimi i izadji</option>
                <option value="6">Podeli na Facebook, i videces i druge</option>
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
            var color2 = colorBrightness(color, -15);
            var rgb2 = rgbToStr(hexToRgb(color2));

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

            $('.replace-btn').minicolors({
                change: function (hex) {
                    setGradient(hex, $(this).closest('.color-cell'));
                    console.log(jsgradient.generateGradient('#07E3F2', '#155994', 10));
                }
            });

            $('.add-btn').minicolors({
                change: function (hex) {
                    var cell = $(this).closest('.color-cell');
                    var clone = $('.my-pattern .cell-template').first().clone();
                    cell.after(clone);
                    setGradient(hex, clone);
                }
            })

            $('.pattern-actions').on('change', function () {
                if ($(this).val() == 4) {
                    var colors = [];
                    var indexes = [];
                    $('.color-selector').each(function (index) {
                        if (this.checked) {
                            colors.push($(this).closest('.color-cell').data('color'));
                            indexes.push(index);
                        }
                    })

                    var steps = indexes[1] - indexes[0];
                    var gradient = jsgradient.generateGradient(colors[0], colors[1], steps - 1);
                    var startIndex = indexes[0] + 1;
                    var currentIndex = 0;

                    $.each(gradient, function (index, value) {
                        currentIndex = startIndex + index;
                        setGradient(value, $('.color-selector:eq(' + currentIndex + ')').closest('.color-cell'));
                    });
                }
            })
        })

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

        function colorBrightness(col, amt) {
            var usePound = false;

            if (col[0] == "#") {
                col = col.slice(1);
                usePound = true;
            }

            var num = parseInt(col, 16);
            var r = (num >> 16) + amt;

            if (r > 255) r = 255;
            else if (r < 0) r = 0;

            var b = ((num >> 8) & 0x00FF) + amt;

            if (b > 255) b = 255;
            else if (b < 0) b = 0;

            var g = (num & 0x0000FF) + amt;

            if (g > 255) g = 255;
            else if (g < 0) g = 0;

            return (usePound ? "#" : "") + String("000000" + (g | (b << 8) | (r << 16)).toString(16)).slice(-6);
        }

    </script>
@stop
