@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }} Order
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Order
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">

                            @if(count($items))
                                <table class="table table-striped table-bordered table-hover sortable"
                                       data-model="{{  get_class($items[0]) }}">
                                    <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        @foreach($headerTitles as $headerTitle => $value)
                                            <th>
                                                {{ $headerTitle }}
                                            </th>
                                        @endforeach
                                        <th>
                                            Check
                                        </th>
                                        <th>
                                            Order
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr data-id="{{ $item->id }}">
                                            <td>
                                                {{ $item->id }}
                                            </td>
                                            @foreach($columns($item) as $columnItem)
                                                <td>
                                                    {{ $columnItem }}
                                                </td>
                                            @endforeach
                                            <td class="text-center">
                                                <input type="checkbox" class="">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-info btn-xs btn-sort">
                                                    <i class="fa fa-arrows-v w20"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div>
                        <!-- /.col-xs-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-xs-12 -->
    </div>

@stop