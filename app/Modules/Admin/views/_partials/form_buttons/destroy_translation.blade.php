@if(isset($item->id) && method_exists($item, 'hasTranslation') && $item->hasTranslation())
    <a href="{{ route('admin.' . $moduleLower . '.destroy.translation', [$item->getTranslation()->id])}}" class="btn btn-danger" data-bb="confirm">
        Delete Translation
    </a>
@endif