<?php
$model = urlencode2(is_null($model) ? get_class($data) : $model);
$changeStatus = 'change-status';
if(isset($changeStatusDisabled)) $changeStatus = '';
?>
@if ($data->status == 1)
    <button class="btn btn-success btn-xs {{ $changeStatus }}" data-id="{{ $data->id }}" data-model="{{ $model }}"><i class="fa fa-check"></i></button>
@elseif($data->status == -1)
    <button class="btn btn-default btn-xs {{ $changeStatus }}"  data-id="{{ $data->id }}" data-model="{{ $model }}"><i class="fa fa-exclamation-triangle"></i></button>
@else
    <button class="btn btn-danger btn-xs {{ $changeStatus }}"  data-id="{{ $data->id }}" data-model="{{ $model }}"><i class="fa fa-power-off"></i></button>
@endif