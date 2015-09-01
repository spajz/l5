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