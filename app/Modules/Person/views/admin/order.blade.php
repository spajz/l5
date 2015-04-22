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
                    Table
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">

                          
                                        <table class="table table-striped table-bordered table-hover sortable"
                                               data-model="{{  get_class($items[0]) }}">
                                            <thead>
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>
                                                    Product
                                                </th>
                                                <th>
                                                    Payment Taken
                                                </th>
                                                <th>
                                                    Status
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
                                                        {{ $item->first_name }}
                                                    </td>
                                                    <td>
                                                        {{ $item->last_name }}
                                                    </td>
                                                    <td>
                                                        {{ $item->order }}
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs btn-sort">
                                                            <i class="fa fa-arrows-v"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>


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