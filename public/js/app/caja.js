var Caja = Caja || {};
Caja = (function() {
    "use strict";
    var router = new Router('caja');
    var dtMovimientos;
    var dtCierres;
    var activeTab = "#movimientos";

    var _actualizarTablas = function() {
        switch (activeTab) {
            case '#movimientos':
                dtMovimientos.ajax.reload();
                dtMovimientos.columns.adjust();
                break;
            case '#cierres':
                dtCierres.ajax.reload();
                dtCierres.columns.adjust();
                break;
        }
    };

    var _cierre = function(e) {
        e.preventDefault();
        var url = $(this).attr('href');

        bootbox.dialog({
            message: 'La caja se pondrá en cero y se generará el informe de cierre ¿Desea continuar?',
            title: 'Cierre de caja',
            buttons: {
                ok: {
                    label: 'Cerrar caja',
                    className: 'btn-success',
                    callback: function() {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType:'json',
                            success: function(result) {
                                if (result.success) {
                                    Common.open(router.urlFor('cierre/imprimir/' + result.id));
                                    _actualizarTablas();
                                } else {
                                    Message.showError(result.message);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                toastr.warning(errorThrown, 'Error fatal');
                            },
                        });
                    }
                },
                cancel: {
                    label: 'Cancelar',
                    className: "btn-default"
                }
            }
        });
    };

    var _movimiento = function(e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            type:'GET',
            url: url
        }).done(function (html) {
            bootbox.dialog({
                message: html,
                title: 'Movimiento de caja',
                buttons: {
                    ok: {
                        label: 'Aceptar',
                        className: 'btn-success',
                        callback: function() {
                            var $form = $('#form-movimiento');

                            if ($form.valid()) {
                                Common.submitForm($form, function(result) {
                                    if (result.success) {
                                        _actualizarTablas();
                                        bootbox.hideAll();
                                        return true;
                                    } else {
                                        Message.showError(result.message);
                                    }
                                });
                            }
                            // Evita que se cierre el dialogo
                            return false;
                        }
                    },
                    cancel: {
                        label: 'Cancelar',
                        className: "btn-default"
                    }
                }
            });
        });
    };

    var _initMovimiento = function () {
        $("#form-movimiento").validate({
            rules: {
                'movimiento-importe': {
                    required: true,
                    number: true
                }
            }
        });
    };

    var _initIndex = function () {
        dtMovimientos = $('#tabla-movimientos').DataTable({
            serverSide: true,
            ajax: router.urlFor('datatable/movimientos'),
            order: [[0, 'desc']],
        });

        dtCierres = $('#tabla-cierres').DataTable({
            serverSide: true,
            ajax: router.urlFor('datatable/cierres'),
            order: [[0, 'desc']],
        });

        $('a[href="#movimientos"]').tab('show');
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            activeTab = $(e.target).attr('href');
            _actualizarTablas();
        });

        $('#cierre').click(_cierre);
        $('#movimiento').click(_movimiento);
    };

    var _agregarCheque = function () {
        var $numero = $('#cheque-numero');
        var bancoId = $('#cheque-banco').val();
        var bancoNombre = $("#cheque-banco").children(":selected").text();
        var $cuit = $('#cheque-cuit');
        var $fecha = $('#cheque-fecha');
        var $importe = $('#cheque-importe');

        if (!$numero.val() || isNaN($numero.val())) {
            alert('El número del cheque es inválido.');
            return;
        }

        if (!bancoId) {
            alert('Seleccione un banco');
            return;
        }

        if (!$fecha.val()) {
            alert('La fecha del cheque es inválida');
            return;
        }

        if (!$importe.val() || isNaN($numero.val())) {
            alert('El importe del cheque es inválido');
            return;
        }

        var row = [
            '<tr><td class="text-right"><input type="hidden" name="detalle-cheque-numero[]" value="', $numero.val(), '">', $numero.val(),
            '</td><td><input type="hidden" name="detalle-cheque-banco[]" value="', bancoId, '">', bancoNombre,
            '</td><td><input type="hidden" name="detalle-cheque-cuit[]" value="', $cuit.val(), '">', $cuit.val(),
            '</td><td class="text-right"><input type="hidden" name="detalle-cheque-fecha[]" value="', $fecha.val(), '">', $fecha.val(),
            '</td><td class="text-right"><input type="hidden" name="detalle-cheque-importe[]" value="', $importe.val(), '">', parseFloat($importe.val()).toFixed(2),
            '</td><td><button class="btn btn-danger eliminar-cheque"><i class="glyphicon glyphicon-remove"></i></button></td></tr>'
        ];

        $('#tabla-cheques > tbody:last-child').append(row.join(''));

        _calcularCheques();
        _limpiarCheque();
        $numero.focus();
    };

    var _calcularTotal = function () {
        var total = 0;

        $('.importe').each(function(index) {
            total += parseFloat($(this).val()) || 0;
        });

        $('#total').val(total.toFixed(2));
    };

    var _calcularCheques = function () {
        var cheques = 0;

        $('input[name="detalle-cheque-importe[]"]').each(function () {
            if (!isNaN(this.value)) {
                cheques += parseFloat(this.value);
            }
        });

        $('#total-cheques').val(cheques.toFixed(2));
        _calcularTotal();
    };

    var _eliminarCheque = function (e) {
        e.preventDefault();
        $(this).parents('tr').remove();
        _calcularCheques();
    };

    var _limpiarCheque = function (e) {
        $('#cheque-numero').val('');
        $('#cheque-cuit').val('');
        $('#cheque-fecha').val('');
        $('#cheque-importe').val('');
    };

    var _initRecibo = function () {
        $('.selectize').selectize({
            selectOnTab: true,
        });

        $('.fecha').datepicker();

        $('.importe').change(function (e) {
            _calcularTotal();
        });

        $('#cheque-importe').keydown(function (e) {
            if (e.which == 13) {
                _agregarCheque();
            }
        });

        $('#agregar-cheque').click(function (e) {
            e.preventDefault();
            _agregarCheque();
        });

        $('#tabla-cheques').on('click', 'button.eliminar-cheque', _eliminarCheque);

        $('#form').validate({
            submitHandler: function(form) {
                Common.ajaxSubmit(form)
                    .done(function(result) {
                        if (result.success) {
                            Common.redirect(router.root);
                        } else {
                            $('#mensaje').html('<strong>Error!</strong> ' + result.message);
                            $('#mensaje').show();
                        }
                    });
            }
        });

        $('#form').keypress(Common.preventEnterSubmit);

    };

    return {
        initIndex: _initIndex,
        initRecibo: _initRecibo,
        initMovimiento: _initMovimiento,
    };
})();
