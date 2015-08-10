<?php
function _result($view)
{
    return md5(Input::get('string'));
}

function _before()
{

}