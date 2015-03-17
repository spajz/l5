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
                        Basic Form Elements
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">

                                {!! Former::text('title') !!}

                                {!! Former::text('slug') !!}

                                {!! Form::hidden('status', 0) !!}

                                {!! Former::checkbox('status') !!}

                                {!! Former::text('ip') !!}

                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9">
                                        <input class="btn btn-success" type="submit" value="Save" name="save[edit]"
                                               data-pjax="1">&nbsp;
                                        <input class="btn btn-success" type="submit" value="Save & Exit"
                                               name="save[exit]">&nbsp;
                                        <input class="btn btn-warning" type="submit"
                                               value="Approve & Publish to Wall & Gallery" name="save[publish]"
                                               data-bb="submit">&nbsp;
                                        <input class="btn btn-warning" type="submit"
                                               value="Approve & Publish to Gallery"
                                               name="save[publish-gallery]" data-bb="submit">&nbsp;
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

    </div>

@stop