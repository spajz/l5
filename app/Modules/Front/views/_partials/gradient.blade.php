<?php
$rgbArray = hex2rgb($color);
$rgb = implode(',', $rgbArray);
?>
background: rgba({{ $rgb }},1);
background: -moz-linear-gradient(-45deg, rgba({{ $rgb }},1) 0%, rgba({{ $rgb }},0.8) 100%);
background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba({{ $rgb }},1)), color-stop(100%, rgba({{ $rgb }},0.8)));
background: -webkit-linear-gradient(-45deg, rgba({{ $rgb }},1) 0%, rgba({{ $rgb }},0.8) 100%);
background: -o-linear-gradient(-45deg, rgba({{ $rgb }},1) 0%, rgba({{ $rgb }},0.8) 100%);
background: -ms-linear-gradient(-45deg, rgba({{ $rgb }},1) 0%, rgba({{ $rgb }},0.8) 100%);
background: linear-gradient(135deg, rgba({{ $rgb }},1) 0%, rgba({{ $rgb }},0.8) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{{ $color }}', endColorstr='{{ $color }}', GradientType=1 );