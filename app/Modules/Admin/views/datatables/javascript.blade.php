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

            @if($columnFilters)

                initComplete: function () {

                    // Move tfoot
                    tableElement.addClass('move-tfoot');

                    var api = this.api();

                    var state = api.state().columns;

                    var columnFilters = {!! json_encode($columnFilters) !!};

                    api.columns().indexes().flatten().each( function ( i ) {

                        var column = api.column(i);

                        var searchValue = '';

                        if(state[i].search.search){
                            searchValue = state[i].search.search;
                        }

                        var dataSrc = column.dataSrc();

                        if(columnFilters.hasOwnProperty(dataSrc)) {

                            var extra = {
                                'filterCount': $(column.footer()).hasClass('filter-count') ? '1' : ''
                            };

                            if (columnFilters[dataSrc] == 'select') {
                                var select = $('<select class="form-control input-xs"><option value=""></option></select>')
                                        .appendTo($(column.footer()).empty())
                                        .on('change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex(
                                                    $(this).val()
                                            );
                                            column.search(val ? val : '', true, false).draw();
                                        });

                                select.append(getModel('{!! addslashes($modelName) !!}', dataSrc, 'option', extra))
                                    .val(searchValue);
                            }

                            if (columnFilters[dataSrc] == 'text') {

                                var text = $('<input type="text" class="form-control input-xs" placeholder="Search">')
                                        .appendTo($(column.footer()).empty())
                                        .val(searchValue)
                                        .on('keyup change', _.debounce(function () {
                                            api.column(i)
                                                    .search(this.value)
                                                    .draw();
                                        }, 500));

                            }
                        }
                    });
                }

            @endif

        });
    });
</script>
