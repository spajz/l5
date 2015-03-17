<table id="{{ $id }}" class="table table-striped table-bordered table-hover {{ $class }}">
    <thead>
    <tr>
        @foreach($columns as $i => $c)
        <th class="head{{ $i }}">{{ $c['title'] }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>