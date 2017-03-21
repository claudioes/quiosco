var Descuento = Descuento || {};
Descuento.router = new Router('descuento');

Descuento.IndexView = function() {
    "use strict";
    var $table = $('#table');
    var router = Descuento.router;

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
                { data: 'descripcion' },
                { data: 'accion',  sortable: false, searchable: false }
            ]
        });

        $("#toolbar").detach().appendTo('div.toolbar-datatable');
        $table.on('click', 'a.delete', _deleteClick);
        Common.temporalAlert($('#mensaje'));
    });
};

Descuento.FormView = function() {
    "use strict";
    var router = Descuento.router;
    var $desde = $('#desde');
    var $hasta = $('#hasta');

    function _generarDescripcion() {
        var descuentoUnidad = Common.parseFloat($('#porcentaje-unidad').val());
        var descuentoMultiplo = Common.parseFloat($('#porcentaje-multiplo').val());
        var multiplo = Common.parseFloat($('#multiplo').val());
        var descuentoCantidad = Common.parseFloat($('#porcentaje-cantidad').val());
        var cantidad = Common.parseFloat($('#cantidad').val());
        var desde = $desde.val();
        var hasta = $hasta.val();
        var familia = $('#familia').children(':selected').text();
        var marca = $('#marca').children(':selected').text();
        var articulo = $('#articulo').children(':selected').text();
        var descripcion;
        var aux = [];

        // Descuentos
        if (descuentoUnidad > 0) aux.push(descuentoUnidad.toString() + '% por unidad');
        if (descuentoMultiplo > 0) aux.push(descuentoMultiplo.toString() + '% por múltiplos de ' + multiplo.toString());
        if (descuentoCantidad > 0) aux.push(descuentoCantidad.toString() + '% por mas de ' + cantidad.toString() + ' unidades');

        if (aux.length) descripcion = aux.join(' o ');
        aux = [];

        // Grupos
        if (marca) aux.push(marca);
        if (familia) aux.push(familia);
        if (articulo) aux.push(articulo);

        if (aux.length) descripcion += ' en ' + aux.join(', ');

        // Validez
        if (desde) descripcion += ' desde el ' + desde;
        if (hasta) descripcion += ' hasta el ' + hasta;

        return descripcion;
    }

    var _clickGenerar = function(e) {
        e.preventDefault();
        var descripcion = _generarDescripcion();
        if (descripcion) {
            $('#descripcion').val(descripcion);
        }
    };

    var _changeDate = function(e) {
        var desde = $desde.datepicker('getDate');
        var hasta = $hasta.datepicker('getDate');

        if (hasta && desde > hasta) {
            $hasta.datepicker('clearDates');
        }

        $hasta.datepicker('setStartDate', desde);
    };

    $(function() {
        $('.selectize').selectize({
            selectOnTab: true,
        });
        $desde.datepicker();
        $hasta.datepicker();

        $("#form").validate({
            rules: {
                'descripcion': 'required',
                'porcentaje-unidad': {
                    number: true,
                    min: 0
                },
                'porcentaje-multiplo': {
                    number: true,
                    min: 0
                },
                'multiplo': {
                    number: true,
                    min: 0,
                    required: function (e) {
                        return Boolean($('#porcentaje-multiplo').val());
                    }
                },
                'porcentaje-cantidad': {
                    number: true,
                    min: 0
                },
                'cantidad': {
                    number: true,
                    min: 0,
                    required: function (e) {
                        return Boolean($('#porcentaje-cantidad').val());
                    }
                },
                'familia': {
                    required: function (e) {
                        return $('#marca').val() === '' && $('#articulo').val() === '';
                    }
                },
                'marca': {
                    required: function (e) {
                        return $('#familia').val() === '' && $('#articulo').val() === '';
                    }
                },
                'articulo': {
                    required: function (e) {
                        return $('#marca').val() === '' && $('#familia').val() === '';
                    }
                }
            },
            messages: {
                'descripcion': 'Ingrese una descripción o generela con el botón "Generar"',
                'familia': {
                    required: "Ingrese al menos un grupo al que se aplicará el descuento"
                },
                'marca': {
                    required: "Ingrese al menos un grupo al que se aplicará el descuento"
                },
                'articulo': {
                    required: "Ingrese al menos un grupo al que se aplicará el descuento"
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

        $desde.datepicker().on('changeDate', _changeDate);
        $('#generar-descripcion').on('click', _clickGenerar);
    });
};
