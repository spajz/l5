<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        oTable = jQuery('#{!! $id !!}').DataTable({

        @foreach ($options as $k => $o)
            {!! json_encode($k) !!}: {!! json_encode($o) !!},
        @endforeach

        @foreach ($callbacks as $k => $o)
            {!! json_encode($k) !!}: {!! $o !!},
        @endforeach

        });
    });
</script>
