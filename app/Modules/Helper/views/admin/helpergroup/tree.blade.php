@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h1 class="page-header">
                <i class="fa {{ modules()[$mainModuleLower]['icon'] }} fa-fw"></i> {{ $moduleTitle or $moduleUpper }} Order
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Tree
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">

                            <div id="tree">
                                <ul>
                                    @foreach($tree as $treeItem)
                                        {!! render_node($treeItem) !!}
                                    @endforeach
                                </ul>
                            </div>

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

@section('scripts_bottom')
    @parent
    <script>
       $(document).ready(function(){
            $('#tree').jstree({
                'plugins' : ['dnd', 'state'],
                'core': {
                    'check_callback' : function(){
                        console.log()
                    },
                },
                'state': {
                    'key': $(this).data('id')
                }
            });

            $('#tree').on("move_node.jstree", function (e, data) {
                var v = $(this).jstree(true).get_json('#', {no_data: true})
                var j = JSON.stringify(v);
                $.ajax({
                    url: baseUrlAdmin + '/api/set-tree',
                    type: 'post',
                    data: {
                        'model': '{{ urlencode2($modelName) }}',
                        'data': j
                    },
                    success: function (data, textStatus, jqXHR) {
                        console.log(data)
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Server error.');
                    },
                });
            });
        });
    </script>
@stop