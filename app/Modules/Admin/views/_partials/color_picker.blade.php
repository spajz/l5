<div class="form-group required color-picker-input">
    <label for="color" class="control-label col-lg-2 col-sm-4">
        {{ $label or $fieldName }}
        @if(isset($validationRules) && (strpos(array_get($validationRules, $fieldName), 'required') !== false))
            <sup>*</sup>
        @endif
    </label>
    <div class="col-lg-10 col-sm-8">
        <div class="input-group">
            <span class="input-group-addon"><i></i></span>
            {!! Former::text($fieldName)->raw() !!}
        </div>
    </div>
</div>