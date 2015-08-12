{!! Former::open()->method('post')->action($route)  !!} 
{!! Former::textarea('string')->rows(8) !!}
{!! Former::actions()->large_primary_submit('Submit') !!}

{!! $result or '' !!}

{!! Former::close() !!}