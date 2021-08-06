<script type="text/javascript">
    $(document).ready(async function() {
        $.noConflict();

        var _token = $('meta[name="csrf-token"]').attr('content');

        var table = await $('#myDataTable').DataTable({
            stateSave: true,
            lengthMenu: [50, 100, 200, 500],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json',
            },
            rowReorder: {
                enable: true,
                update: false
            },
            order: [],
            aaSorting: [],
            columnDefs: [{
                "orderable": false,
                className: 'reorder',
                "targets": [0, -1]
            }],
            paging: true,
            autoWidth: false

        });


        table.on('row-reorder', function(e, diff, ) {
            // result tendrá un array con {id, orden} solo de
            // los tr que cambiaron de orden
            //result.id = Valor de primer columna
            //result.position = Pos actual
            var result = diff.map(function(diff) {
                var res = {};

                res.id = diff.node.dataset.id;
                res.position = diff.newPosition;
                //res.realPosition = diff.node.dataset.position;
                return res;


            });


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                url: "{{ route('admin.menus.reorder-table') }}",
                method: 'POST',
                data: {
                    result,
                    _token
                }
            })

        });


    });

</script>
