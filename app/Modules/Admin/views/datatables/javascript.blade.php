<script type="text/javascript">
    $(document).ready(function(){

        var responsiveHelper;
        var breakpointDefinition = {
            tablet: 1024,
            phone : 480
        };

        var tableElement = $('#{!! $id !!}');

        tableElement.on( 'processing.dt', function ( e, settings, processing ) {
            if(processing) loaderShow();
            else loaderHide();
        })

        tableElement.DataTable({

            @foreach ($options as $k => $o)
                {!! json_encode($k) !!}: {!! json_encode($o) !!},
            @endforeach

            preDrawCallback: function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper) {
                    responsiveHelper = new ResponsiveDatatablesHelper(tableElement, breakpointDefinition);
                }
            },
            rowCallback    : function (nRow) {
                responsiveHelper.createExpandIcon(nRow);
            },
            drawCallback   : function (oSettings) {
                responsiveHelper.respond();
            },



        initComplete: function () {
            var api = this.api();

//            var model = getModel('App\\Modules\\Person\\Models\\Person');

            api.columns().indexes().flatten().each( function ( i ) {
                var column = api.column( i );
                var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                            );

                            column
                                    .search( val ? val : '', true, false )
                                    .draw();
                        } );

                console.log(column.dataSrc());

                if( column.dataSrc() == 'first_name'){
                    select.append(getModel('App\\Modules\\Person\\Models\\Person', column.dataSrc(), 'option') )
                }

//                column.data().unique().sort().each( function ( d, j ) {
//                    select.append( '<option value="'+d+'">'+d+'</option>' )
//                } );
            } );
        }
    });


    // type: json | list | option
    function getModel(model, column, type) {
        type = typeof type !== 'undefined' ? type : 'json';
        column = typeof column !== 'undefined' ? column : '*';
        var out = '';
        $.ajax({
            url: baseUrlAdmin + '/api/get-model',
            type: 'post',
            data: {
                "model": model,
                "column": column,
                "type": type,
            },
            success: function (data, textStatus, jqXHR) {
                out = data;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Server error.');
            },
            async: false
        });

        return out;
    }





    });
</script>
