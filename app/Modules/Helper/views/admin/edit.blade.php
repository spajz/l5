@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$moduleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }} Edit
            </h1>
        </div>
    </div>

    <div id="pjax-container">

        <div id="info-box">{!! Notification::showAll() !!}</div>

        {!! Former::open_for_files()->route("admin.{$moduleLower}.update", $item->id)->method('put')->data_pjax()->rules($validationRules) !!}

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

                                {!! Former::text('title') !!}

                                {!! Former::text('slug') !!}

                                {!! Former::select('helper_group_id')->options($groups)->class('select2')->label('Group') !!}

                                {!! Former::textarea('intro') !!}

                                {!! Former::textarea('description')->addClass('ckeditor') !!}

                                {!! Former::hidden('featured')->forceValue(0) !!}
                                {!! Former::checkbox('featured')->value(1) !!}

                                {!! Former::hidden('status')->forceValue(0) !!}
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
                        Code Edit
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">

                                {!! Former::select('type')->options($config['type'])->class('select2') !!}

                                {!! Former::text('add_custom_file') !!}

                                @if(count($deleteFiles))
                                    {!! Former::checkboxes('delete_files')->checkboxes($deleteFiles) !!}
                                @endif

                                <?php $i=0; ?>
                                @if($contentFiles)
                                    @foreach($contentFiles as $file => $contentFile)
                                        <div class="form-group">
                                            <label class="col-sm-3 col-md-3 col-lg-2 control-label">{{ $file }}</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <div class="editor-box" id="editor-box-{{$i}}" style="min-height: 600px;"></div>
                                                <textarea style="display: none" name="{{ base64_encode($file) }}" rows="5" cols="70" id="editor-form-{{$i}}">{{ $contentFile }}</textarea>
                                            </div>
                                        </div>
                                        <?php $i++; ?>
                                    @endforeach
                                @endif

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

        @include("admin::_partials.images_form", ['item' => $item])

        {!! Former::close() !!}

        @if(array_get($config, 'image.crop'))
            @include("admin::_partials.crop_form", ['item' => $item])
        @endif

    </div>

@stop

@section('scripts_bottom')
    @parent
    <script src="{{ admin_asset('js/ace-builds/ace.js') }}"></script>
    <script>
        var textarea = {};
        var editor = {};
        var initialContent = '';

        function initEditor(){
            $('.editor-box').each(function (index) {
                initialContent = $('#editor-form-' + index).val();
                textarea[index] = $('#editor-form-' + index);
                //$('#editor-form-' + index).hide();
                editor[index] = ace.edit('editor-box-' + index);
                editor[index].setValue(initialContent);
                editor[index].setTheme("ace/theme/twilight");
                editor[index].getSession().setMode("ace/mode/php");
                editor[index].getSession().on('change', function () {
                    textarea[index].val(editor[index].getSession().getValue());
                });
            });
        }

        initEditor();

        $("#toggletextarea-btn").on('click', function () {
            textarea.toggle();
            $(this).text(function (i, text) {
                return text === "Show Content" ? "Hide Content" : "Show Content";
            });
        });

        $(document).on('pjax:complete', function() {
            initEditor();
        })
    </script>
@stop