<div class="form-group">
    <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9 font0">
        @if($formButtons)
            @foreach($formButtons as $formButton)
                @include('admin::_partials.form_buttons.' . $formButton)
            @endforeach
        @endif
        {!! $extra !!}
    </div>
</div>
