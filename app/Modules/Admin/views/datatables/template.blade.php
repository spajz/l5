<table id="{{ $id }}" class="table table-striped table-bordered table-hover {{ $class }}">
    <thead>
    <tr>
        @foreach($columns as $i => $c)
        <th class="head{{ $i }} {{ array_get($thClass, $c['name']) }}">{{ $c['title'] }}</th>
        @endforeach
    </tr>
    </thead>
    <tfoot>
    <tr>
        @foreach($columns as $i => $c)
            <td class="{{ array_get($tfClass, $c['name']) }}"></td>
        @endforeach
    </tr>
    </tfoot>
    <tbody>

    </tbody>
</table>