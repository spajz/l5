@if (is_ajax())
    {!! Former::open_for_files()->class('added-form') !!}
@endif

@if(isset($item))

    @include("admin::_partials.images_form", ['item' => $item])

@else

    @include("admin::_partials.images_form")

@endif

@if (is_ajax())
    {!! Former::close() !!}
@endif