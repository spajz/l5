@if(isset($item->id))
<a href="{{ route('admin.' . $moduleLower . '.destroy', [$item->id, 'redirect' => 'index'])}}" class="btn btn-danger" data-bb="confirm">
    Delete
</a>
@endif