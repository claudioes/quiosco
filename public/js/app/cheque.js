var Cheque = Cheque || {};
Cheque = (function() {
    "use strict";
    var router = new Router('cheque');

    var deleteClick = function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        Common.eliminarDatatable(router.urlFor(id), id);
    };

    var initIndex = function () {
        var $table = $('#table');

        var dt = $table.DataTable({
            serverSide: true,
            ajax: router.urlFor('datatable'),
            columns: [
                { data: 'estado', className: 'text-center' },
                { data: 'numero', className: 'text-right' },
                { data: 'banco_nombre' },
                { data: 'cuit' },
                { data: 'fecha', className: 'text-right' },
                { data: 'importe', className: 'text-right' },
                { data: 'vencimiento', className: 'text-right' },
                { data: 'accion', sortable: false, searchable: false }
            ]
        });

        $("#toolbar").detach().appendTo('div.toolbar-datatable');
        $table.on('click', 'a.delete', deleteClick);
        Common.temporalAlert($('#mensaje'));
    };

    var initForm = function () {
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

        $('#articulos').DataTable();

        $('.date').datepicker();
        $('.selectize').selectize();
    };

    return {
        initIndex: initIndex,
        initForm: initForm,
    };
})();
