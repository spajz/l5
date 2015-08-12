<?php
function _result($id = null)
{
    return Former::text('result')
        ->forceValue(md5(Input::get('string')))
        ->disabled();
}

function _before($id = null)
{

}