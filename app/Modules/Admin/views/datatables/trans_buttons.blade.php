@if($languages)
    @foreach($languages as $lang)
        @if($item->lang == (isset($transRelated[$lang]) ? $lang : false))
            <a href="{{ route("admin.{$moduleLower}.edit", $item->id)}}" class="btn btn-default {{ $buttonSize or '' }}">{{ $lang }}</a>
        @elseif(isset($transRelated[$lang]))
            <a href="{{ route("admin.{$moduleLower}.edit", $transRelated[$lang]->id)}}" class="btn btn-success {{ $buttonSize or '' }}">{{ $lang }}</a>
        @else
            <a href="{{ route("admin.{$moduleLower}.create", [$item->id, $lang])}}" class="btn btn-danger {{ $buttonSize or '' }}">{{ $lang }}</a>
        @endif
    @endforeach
@endif
