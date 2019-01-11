App.Cliente = (function() {
    "use strict";

    return {
        Index: function () {
            var $table = $('#table');

            var dt = $table.DataTable({
                serverSide: true,
                ajax: App.pathFor('cliente/datatable'),
                columns: [
                    { data: 'codigo', className: 'text-right' },
                    { data: 'nombre' },
                    { data: 'localidad' },
                    {
                        data: 'saldo',
                        className: 'text-right',
                        searchable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var clase = 'saldo-cero';
                            var saldo = parseFloat(cellData);

                            if (saldo < 0 ) {
                                clase = 'saldo-positivo';
                            } else if (saldo > 0) {
                                clase = 'saldo-negativo';
                            }

                            $(td).addClass(clase);
                        }
                    },
                    { data: 'accion', sortable: false, searchable: false }
                ],
            });

            $table.on('click', 'a.delete', function (e) {
                e.preventDefault();
                Common.ajaxDelete('cliente', $(this).data('id'));
            });

            $("#toolbar").detach().appendTo('div.toolbar-datatable');
        },

        Form: function () {
            function mostrarCuentaCorriente() {
                var $desde = $('#cc-desde');
                var $hasta = $('#cc-hasta');
                var $cliente = $('#id');
                var clienteId;

                if ($cliente.length && (clienteId = $cliente.val())) {
                    var fechaDesde = $desde.val();
                    var fechaHasta = $hasta.val();
                    var data = {};

                    if (fechaDesde) {
                        data.desde = fechaDesde;
                    }

                    if (fechaHasta) {
                        data.hasta = fechaHasta;
                    }

                    $('#cc-tabla')
                        .html('<div class="text-center">Cargando...</div>')
                        .load(App.pathFor('cliente/cc/' + clienteId, data));
                }
            }

            function imprimirCuentaCorriente() {
                var $desde = $('#cc-desde');
                var $hasta = $('#cc-hasta');
                var $cliente = $('#id');
                var clienteId;

                if ($cliente.length && (clienteId = $cliente.val())) {
                    var fechaDesde = $desde.val();
                    var fechaHasta = $hasta.val();
                    var data = {};

                    if (fechaDesde) {
                        data.desde = fechaDesde;
                    }

                    if (fechaHasta) {
                        data.hasta = fechaHasta;
                    }

                    window.open(App.pathFor('cliente/cc/' + clienteId + '/imprimir', data), '_blank');
                }
            }

            function buscarCuit($el) {
                var cuit = $('#cuit').val().trim().replace('-', '');
                $el.prop('disabled', true);

                if (cuit) {
                    $.ajax({
                        url: 'https://soa.afip.gob.ar/sr-padron/v2/persona/' + cuit,
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                var persona = result.data;
                                var domicilio = persona.domicilioFiscal;

                                $('#razon').val(persona.nombre);

                                if (domicilio) {
                                    $('#domicilio').val(domicilio.direccion);
                                    $('#localidad').val(domicilio.localidad);
                                    $('#cp').val(domicilio.codPostal);
                                } else {
                                    $('#domicilio').val('');
                                    $('#localidad').val('');
                                    $('#cp').val('');
                                }
                            } else {
                                Message.showError('No se encontró el CUIT. Verifique que esté bien escrito y vuelva a intentarlo', 'CUIT inexistente');
                            }
                            $el.prop('disabled', false);
                        }
                    });
                }
            }

            var $form = $('#form');
            var $desde = $('#cc-desde');
            var $hasta = $('#cc-hasta');
            var $cliente = $('#id');

            $desde.datepicker().on('changeDate', function (e) {
                mostrarCuentaCorriente();
            });

            $hasta.datepicker().on('changeDate', function (e) {
                mostrarCuentaCorriente();
            });

            $form.validate({
                rules: {
                    codigo: {
                        required: true,
                        digits: true
                    },
                },
                submitHandler: function(form) {
                    Common.submitForm($(form), function(result) {
                        if (result.success) {
                            window.location.href = App.pathFor('cliente');
                        } else {
                            $('#error').html('<strong>Error!</strong> ' + result.message);
                            $('#error').show();
                        }
                    });
                }
            });

            $('#buscar-cuit').click(function (e) {
                buscarCuit($(this));
            });

            $('#imprimir-cc').click(function (e) {
                imprimirCuentaCorriente();
            });

            $('#mostrar-cc').click(function (e) {
                mostrarCuentaCorriente();
            });

            $('.datepicker').datepicker();
        }
    };


})();
