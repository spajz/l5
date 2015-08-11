{!! Former::open()->method('post')->action($route)  !!} 
{!! Former::textarea('string')->value(Input::old('string'))->rows(8) !!}
{!! Former::actions()->large_primary_submit('Submit') !!}

{!! session()->get('_result')!!}

{!! Former::close() !!}