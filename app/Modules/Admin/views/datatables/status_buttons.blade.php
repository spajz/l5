<?php
$model = urlencode2(is_null($model) ? get_class($data) : $model);
$changeStatus = 'change-status';
if(!isset($column)) $column = 'status';
if(isset($changeStatusDisabled)) $changeStatus = '';
?>
@if ($data->{$column} == 1)
    <button class="btn btn-success {{ $buttonSize or '' }} {{ $changeStatus }}" data-id="{{ $data->id }}" data-model="{{ $model }}" data-column="{{ $column }}"><i class="fa fa-check"></i></button>
@elseif($data->{$column} == -1)
    <button class="btn btn-default {{ $buttonSize or '' }} {{ $changeStatus }}"  data-id="{{ $data->id }}" data-model="{{ $model }}" data-column="{{ $column }}"><i class="fa fa-exclamation-triangle"></i></button>
@else
    <button class="btn btn-danger {{ $buttonSize or '' }} {{ $changeStatus }}"  data-id="{{ $data->id }}" data-model="{{ $model }}" data-column="{{ $column }}"><i class="fa fa-power-off"></i></button>
@endif