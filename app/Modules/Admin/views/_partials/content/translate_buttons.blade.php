@if(count(config('admin.languages')))
    @foreach(config('admin.languages') as $langCode => $langName)
        @if(isset($item))
            @if($item->hasTranslation($langCode))
                <button type="button" class="btn btn-xs btn-success no-click">{{ $langCode }}</button>
            @else
                <button type="button" class="btn btn-xs btn-danger no-click">{{ $langCode }}</button>
            @endif
        @else
            <button class="btn btn-xs btn-danger">{{ $langCode }}</button>
        @endif
    @endforeach
@endif
