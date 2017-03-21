var Cobrador = Cobrador || {};
Cobrador.router = new Router('cobrador');

Cobrador.FormView = function() {
    "use strict";
    var router = Cobrador.router;

    $(function() {
        $("#form").validate({
            rules: {
                nombre: 'required',
            },
            messages: {
                nombre: "Ingrese un nombre"
            },
            submitHandler: function(form) {
                Common.submitForm($(form), function(result) {
                    if (result.success) {
                        Common.redirect(router.root);
                    } else {
                        $('#mensaje').html('<strong>Error!</strong> ' + result.message);
                        $('#mensaje').show();
                    }
                });
            }
        });
    });
};

Cobrador.IndexView = function() {
    "use strict";
    var $table = $('#table');
    var router = Cobrador.router;

    var _deleteClick = function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        Common.eliminarDatatable(router.urlFor(id), id);
    };

    $(function() {
        var dt = $table.DataTable({
            serverSide: true,
            ajax: router.urlFor('datatable'),
            columns: [
                { data: 'nombre' },
                { data: 'accion', sortable: false, searchable: false }
            ]
        });

        $("#toolbar").detach().appendTo('div.toolbar-datatable');
        $table.on('click', 'a.delete', _deleteClick);
        Common.temporalAlert($('#mensaje'));
    });
};
