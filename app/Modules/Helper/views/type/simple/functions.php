<?php
// Views ['form']
function _result($baseView)
{
    return md5(Input::get('string'));
}

function _before($baseView)
{

}