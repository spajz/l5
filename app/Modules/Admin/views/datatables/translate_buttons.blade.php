@if(count($languages))
    @foreach($languages as $langCode => $langName)
        @if(isset($translation[$langCode]) && $translation[$langCode])
            <a href="{{ route('admin.' . $moduleLower . '.edit', [$item->id, $langCode]) }}" class="btn btn-success {{ $buttonSize or '' }}">{{ $langCode }}</a>
        @else
            <a href="{{ route('admin.' . $moduleLower . '.edit', [$item->id, $langCode]) }}" class="btn btn-danger {{ $buttonSize or '' }}">{{ $langCode }}</a>
        @endif
    @endforeach
@endif
