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
                                            <table class="table sortable"
                                                   data-model="{{  get_property_class($item, 'images') ?  get_property_class($item, 'images') : '' }}">
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
                                                <tr>
                                                    <td>
                                                        1
                                                    </td>
                                                    <td>
                                                        TB - Monthly
                                                    </td>
                                                    <td>
                                                        01/04/2012
                                                    </td>
                                                    <td>
                                                        Default
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs btn-sort">
                                                            <i class="fa fa-arrows-v"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="active">
                                                    <td>
                                                        1
                                                    </td>
                                                    <td>
                                                        TB - Monthly
                                                    </td>
                                                    <td>
                                                        01/04/2012
                                                    </td>
                                                    <td>
                                                        Approved
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs btn-sort">
                                                            <i class="fa fa-arrows-v"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="success">
                                                    <td>
                                                        2
                                                    </td>
                                                    <td>
                                                        TB - Monthly
                                                    </td>
                                                    <td>
                                                        02/04/2012
                                                    </td>
                                                    <td>
                                                        Declined
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs btn-sort">
                                                            <i class="fa fa-arrows-v"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="warning">
                                                    <td>
                                                        3
                                                    </td>
                                                    <td>
                                                        TB - Monthly
                                                    </td>
                                                    <td>
                                                        03/04/2012
                                                    </td>
                                                    <td>
                                                        Pending
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs btn-sort">
                                                            <i class="fa fa-arrows-v"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="danger">
                                                    <td>
                                                        4
                                                    </td>
                                                    <td>
                                                        TB - Monthly
                                                    </td>
                                                    <td>
                                                        04/04/2012
                                                    </td>
                                                    <td>
                                                        Call in to confirm
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs btn-sort">
                                                            <i class="fa fa-arrows-v"></i>
                                                        </button>
                                                    </td>
                                                </tr>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#overlay-modal').modal();
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function () {


            $('.sortable').sortable({
                items: 'tr',

                handle: '.btn-sort',
                forcePlaceholderSize: true,
                cancel: '',

                helper: function(e, ui)
                {
                    ui.children().each(function() {
                        $(this).width($(this).width());
                    });
                    return ui;
                }

            }).bind('sortupdate', function (e, ui) {

                var sort = {};
                $('.sortable tr').each(function (index) {
                    console.log($(this).data('id'));
                    console.log(index);
                    sort[index] = $(this).data('id');
                    model = $(this).data('model');
                });

                var model = $('.sortable tr').first().data('model');

                //sortRows(model, sort);

            });
        });
    </script>


@stop