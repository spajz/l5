<script type="text/javascript">
    jQuery(document).ready(function(){

        var responsiveHelper;
        var breakpointDefinition = {
            tablet: 1024,
            phone : 480
        };

        tableElement = jQuery('#{!! $id !!}');

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
            }

        });
    });
</script>
