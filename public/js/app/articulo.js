App.Articulo = (function() {
    "use strict";

    return {
        Index: function () {
            var $table = $('#table');
            var ajaxCalls = 0;
            var ajaxTimeout;

            var dt = $table.DataTable({
                serverSide: true,
                ajax: App.pathFor('articulo/datatable'),
                columns: [
                    { data: 'codigo', className: 'text-right'},
                    { data: 'descripcion' },
                    { data: 'stock', className: 'text-right', searchable: false },
                    { data: 'costo', searchable: false },
                    { data: 'ganancia', searchable: false, sortable: false },
                    { data: 'precio', searchable: false, },
                    { data: 'accion', sortable: false, searchable: false }
                ]
            });

            $table.on('click', 'a.delete', function(e) {
                e.preventDefault();
                Common.ajaxDelete('cliente', $(this).data('id'));
            });

            $table.on('change', ':input.editable', function(e) {
                var $input = $(this);
                var $row = $input.closest('tr');
                var $inputPrecio = $(':input.precio', $row);

                var articuloId = $input.data('id');
                var fieldName = $input.data('field');
                var value = Common.parseFloat($input.val());

                $input.prop('disabled', true);
                $inputPrecio.removeClass('success-post');
                $inputPrecio.prop('disabled', true);
                ajaxCalls++;

                $.post(App.pathFor('articulo/guardarprecio'), {
                    'id': articuloId,
                    'field': fieldName,
                    'value': value
                }, function(result) {
                    if (result.success) {
                        var data = result.data;
                        $input.val(value.toFixed(2));

                        if (fieldName !== 'precio') {
                            $inputPrecio.val(data.precio.toFixed(2));
                        }
                    }
                }, 'json')
                .fail(function(jqXHR, textStatus, errorThrown) {
                    Message.showWarning(errorThrown, 'Error en el servidor');
                })
                .always(function() {
                    $input.prop('disabled', false);

                    ajaxCalls--;
                    if (ajaxCalls === 0) {
                        $inputPrecio.prop('disabled', false);
                        $inputPrecio.addClass('success-post');
                        clearTimeout(ajaxTimeout);
                        ajaxTimeout = window.setTimeout(function(){
                            $inputPrecio.removeClass('success-post');
                        }, 10000);
                    }
                });
            });

            $("#toolbar").detach().appendTo('div.toolbar-datatable');
        },

        Form: function () {
            function calcularPrecio() {
                var costo = parseFloat($("#costo").val()) || 0;
                var ganancia = parseFloat($("#ganancia").val()) || 0;
                return costo * (1 + ganancia / 100);
            }

            function mostrarMovimientos() {
                var $movimientos = $('#movimientos');
                var $desde = $('#movimientos-desde');
                var $deposito = $('#movimientos-deposito');
                var data = {
                    'articulo': $('#articulo-id').val(),
                    'deposito': $deposito.val(),
                    'desde': $desde.val(),
                };

                $desde.prop('disabled', true);
                $deposito.prop('disabled', true);
                $movimientos.html('Cargando...');

                $.ajax({
                    url: App.pathFor('articulo/movimientos'),
                    data: data,
                    type: 'GET'
                }).done(function (result) {
                    $movimientos.html(result);
                }).always(function () {
                    $desde.prop('disabled', false);
                    $deposito.prop('disabled', false);
                });
            }

            $('#form').validate({
                rules: {
                    codigo: {
                        required: true,
                        digits: true
                    },
                },
                submitHandler: function(form) {
                    Common.submitForm($(form), function(result) {
                        if (result.success) {
                            Common.redirect(App.pathFor('articulo'));
                        } else {
                            $('#mensaje').html('<strong>Error!</strong> ' + result.message);
                            $('#mensaje').show();
                        }
                    });
                }
            });

            $('.calcular').on('input', function(e) {
                $('#precio').val(calcularPrecio().toFixed(2));
            });

            if ($('#id').length) {
                mostrarMovimientos();

                $('#movimientos-desde').datepicker();

                $('#movimientos-desde').change(function (e) {
                    mostrarMovimientos();
                });

                $('#movimientos-deposito').change(function (e) {
                    mostrarMovimientos();
                });
            }
        },

        Aumento: function () {
            $('.selectize').selectize({
                selectOnTab: true,
            });

            $('#form').validate({
                rules: {
                    valor: {
                        required: function(e) {
                            return ($('#accion').val() != 'rc');
                        },
                        number: true
                    }
                },
                submitHandler: function(form) {
                    var $accion = $('#accion');
                    var $familia = $('#familia');
                    var $marca = $('#marca');
                    var $proveedor = $('#proveedor');
                    var valor = $('#valor').val();

                    var aux = [];
                    var mensaje = [
                        'Está a punto de ',
                        $accion.children(':selected').text().toLowerCase()
                    ];

                    if ($familia.val() > 0) {
                        aux.push('de', $familia.children(':selected').text().toLowerCase());
                    }
                    if ($marca.val() > 0) {
                        aux.push('de la marca', $marca.children(':selected').text());
                    }
                    if ($proveedor.val() > 0) {
                        aux.push('del proveedor', $proveedor.children(':selected').text());
                    }

                    if (aux.length) {
                        mensaje.push(aux.join(' '));
                    } else {
                        mensaje.push('de <strong>todos</strong> los artículos');
                    }

                    if (valor) {
                        mensaje.push(
                            'a <strong>', parseFloat(valor).toFixed(2) + '%', '</strong>');
                    }

                    mensaje.push('<br>La operación <strong>no se podrá deshacer</strong> ¿Desea continuar?');

                    Common.confirm(mensaje.join(' '), function(result) {
                        if (result) {
                            Common.submitForm($(form), function(result) {
                                if (result.success) {
                                    Common.redirect(App.pathFor('articulo'));
                                } else {
                                    $('#mensaje').html('<strong>Error!</strong> ' + result.message);
                                    $('#mensaje').show();
                                }
                            });
                        }
                    });
                }
            });

            $('#accion').change(function(e) {
                var accion = $(this).val();
                $('#div-valor').show();
                switch(accion) {
                    case 'ct': // Costo
                    case 'pv': // Precio de venta
                        $('#label-valor').html('Porcentaje');
                        break;
                    case 'gc': // Ganancia
                        $('#label-valor').html('Nuevo valor');
                        break;
                    case 'rc': // Recalcular
                        $('#div-valor').hide();
                        break;
                }
            });
        }
    };
})();
