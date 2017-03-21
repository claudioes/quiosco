var Grupo = Grupo || {};
Grupo.router = new Router('grupo');

Grupo.FormView = function() {
    "use strict";
    var router = Grupo.router;

    $(function() {
        $("#form").validate({
            rules: {
                nombre: 'required',
                descuento: {
                    number: true,
                    min: 0
                },
                aumento: {
                    number: true,
                    min: 0
                }
            },
            messages: {
                nombre: "Ingrese un nombre",
                descuento: {
                    number: 'Ingrese un número entero positivo',
                    min: 'El descuento debe ser mayor a 0'
                },
                aumento: {
                    number: 'Ingrese un número entero positivo',
                    min: 'El aumento debe ser mayor a 0'
                }
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
        $('#clientes').DataTable();
    });
};

Grupo.IndexView = function() {
    "use strict";
    var $table = $('#table');
    var router = Grupo.router;

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
                { data: 'descuento', className: 'text-right' },
                { data: 'recargo', className: 'text-right' },
                { data: 'accion', sortable: false, searchable: false }
            ]
        });

        $("#toolbar").detach().appendTo('div.toolbar-datatable');
        $table.on('click', 'a.delete', _deleteClick);
        Common.temporalAlert($('#mensaje'));
    });
};
