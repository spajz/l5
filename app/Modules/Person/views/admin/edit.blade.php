@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }} Edit
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <p>{!! $transButtons !!}</p>
        </div>
    </div>

    <div id="pjax-container">

        {!! Former::open_for_files()->route("admin.{$moduleLower}.update", $item->id)->method('put') !!}

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Basic Information
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">

                                {!! Former::hidden('id') !!}

                                {!! Former::text('first_name') !!}

                                {!! Former::text('last_name') !!}

                                {!! Former::text('job_title') !!}

                                {!! Former::textarea('description') !!}

                                {!! Former::text('lang')->value('sr') !!}

                                {!! Former::checkbox('status')->value(1) !!}

                                {!! $formButtons or '' !!}

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

        <div class="row">
            <div class="col-xs-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Images
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">

                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Alt</th>
                                        <th>Sort</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(count($item->images))
                                        <tr>

                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="4">There is no items.</td>
                                        </tr>
                                    @endif
                                    </tbody>

                                </table>


                                <div class="form-group">
                                    <label class="col-xs-3 col-lg-2 control-label">New image upload</label>

                                    <div class="col-xs-9 col-lg-10">
                                        <div class="row bottom15">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" value="" name="alt_new[]"
                                                       placeholder="Enter alt text..."/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse&hellip; <input type="file" multiple name="files_new[]">
                                                        </span>
                                                    </span>
                                                    <input type="text" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse&hellip; <input type="file" multiple name="files_new[]">
                                                        </span>
                                                    </span>
                                                    <input type="text" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse&hellip; <input type="file" multiple name="files_update[45]">
                                                        </span>
                                                    </span>
                                                    <input type="text" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>


                            </div>
                            <!-- /.col-xs-12 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>

        {!! Former::close() !!}

    </div>

@stop