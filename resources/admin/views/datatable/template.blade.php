<table id="{{ $id }}" class="table table-striped table-bordered table-hover {{ $class }}">
    <thead>
    <tr>
        @foreach($columns as $i => $c)
        <th align="center" valign="middle" class="head{{ $i }}">{{ $c['title'] }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>