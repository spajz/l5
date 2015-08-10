{!! Former::open()->method('post')->action($route)  !!} 
{!! Former::textarea('string')->value(Input::old('string'))->rows(8) !!}
{!! Former::actions()->large_primary_submit('Submit') !!}

@if(isset($result))
    {!!
        Former::text('result')
        ->forceValue($result)
        ->disabled()->rows(8)
    !!}
@endif

{!! Former::close() !!}