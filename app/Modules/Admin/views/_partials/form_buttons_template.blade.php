<div class="form-group">
    <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9 font0">
        <div class="btn-form-group">
            @if($formButtons)
                @foreach($formButtons as $formButton)
                    @include('admin::_partials.form_buttons.' . $formButton)
                @endforeach
            @endif
        </div>
        {!! $extra !!}
    </div>
</div>