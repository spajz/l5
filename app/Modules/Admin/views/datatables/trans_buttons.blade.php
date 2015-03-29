@if($languages)
    @foreach($languages as $lang)
        @if($item->lang == (isset($transRelated[$lang]) ? $lang : false))
            <a href="{{ route("admin.{$moduleLower}.edit", $item->id)}}" class="btn btn-default btn-xs">{{ $lang }}</a>
        @elseif(isset($transRelated[$lang]))
            <a href="{{ route("admin.{$moduleLower}.edit", $transRelated[$lang]->id)}}" class="btn btn-success btn-xs">{{ $lang }}</a>
        @else
            <a href="{{ route("admin.{$moduleLower}.create", [$item->id, $lang])}}" class="btn btn-danger btn-xs">{{ $lang }}</a>
        @endif
    @endforeach
@endif
