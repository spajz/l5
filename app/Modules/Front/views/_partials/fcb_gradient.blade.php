<?php
$rgbArray = hex2rgb($color);
$color2 = color_brightness($color, -50);
$rgbArray2 = hex2rgb($color2);
$rgb1 = implode(',', $rgbArray);
$rgb2 = implode(',', $rgbArray2);
?>
background: rgba({{ $rgb1 }},1);
background: -moz-linear-gradient(top, rgba({{ $rgb1 }},1) 0%, rgba({{ $rgb2 }},1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba({{ $rgb1 }},1)), color-stop(100%, rgba({{ $rgb2 }},1)));
background: -webkit-linear-gradient(top, rgba({{ $rgb1 }},1) 0%, rgba({{ $rgb2 }},1) 100%);
background: -o-linear-gradient(top, rgba({{ $rgb1 }},1) 0%, rgba({{ $rgb2 }},1) 100%);
background: -ms-linear-gradient(top, rgba({{ $rgb1 }},1) 0%, rgba({{ $rgb2 }},1) 100%);
background: linear-gradient(to bottom, rgba({{ $rgb1 }},1) 0%, rgba({{ $rgb2 }},1) 100%);
<?php /*
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{{ $color }}', endColorstr='{{ $color2 }}', GradientType=0 );
 */
 ?>