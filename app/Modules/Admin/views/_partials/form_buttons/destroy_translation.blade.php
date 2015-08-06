@if(isset($item->id) && $item->hasTranslation())
    <a href="{{ route('admin.' . $moduleLower . '.destroy.translation', [$item->getTranslation()->id])}}" class="btn btn-danger" data-bb="confirm">
        Delete Translation
    </a>
@endif