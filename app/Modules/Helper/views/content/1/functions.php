<?php
function _result($view = null)
{
    return view($view, ['result' => md5(Input::get('string'))])->render();
}

function _before()
{

}