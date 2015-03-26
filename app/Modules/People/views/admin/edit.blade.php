@extends($layout)

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit</h1>
        </div>
    </div>

    <div id="pjax-container">

        {!! Former::open_for_files()->route("admin.{$moduleLower}.update", $item->id)->method('put')->data_pjax() !!}

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Basic Information
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">

                                {!! Former::text('title') !!}

                                {!! Former::checkbox('status')->value(1)->unchecked_value(0) !!}

                                {!! Former::text('ip') !!}

                                {!! Former::textarea('slug')->id('ckeditor') !!}

                                {!! Former::select('clients')->options(array('a', 'b', 'c', 1, 2, 3, 4, 5, 6),
                                123)->class('select2') !!}

                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9">
                                        <a href="{{ route("admin.{$moduleLower}.index") }}" class="btn btn-default">Back
                                            To List</a>
                                        <input class="btn btn-success" type="submit" value="Save" name="save[edit]"
                                               data-pjax="1">&nbsp;
                                        <input class="btn btn-success" type="submit" value="Save & Exit"
                                               name="save[exit]">&nbsp;
                                        <input class="btn btn-warning" type="submit"
                                               value="Approve" name="save[publish]"
                                               data-bb="submit">&nbsp;
                                        <input class="btn btn-inverse" type="submit" value="Reject" name="save[reject]"
                                               data-bb="submit">&nbsp;
                                    </div>
                                </div>

                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

        {!! Former::close() !!}


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Table
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="container">
                                    <div class="row clearfix">
                                        <div class="col-md-12 column">
                                            <table class="table table-striped table-bordered table-hover sortable"
                                                   data-model="{{  get_class($item) }}">
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
                                                        Sort
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($people as $p)
                                                    <tr data-id="{{ $p->id }}">
                                                        <td>
                                                            {{ $p->title }}
                                                        </td>
                                                        <td>
                                                            {{ $p->id }}
                                                        </td>
                                                        <td>
                                                            {{ $p->order }}
                                                        </td>
                                                        <td>
                                                           <input type="checkbox"  class="">
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
                                    </div>
                                </div>


                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>


    </div>

@stop

@section('scripts_bottom')
@parent

@stop