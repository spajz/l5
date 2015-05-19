


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

                        {!! Former::textarea('description')->addClass('ckeditor') !!}

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