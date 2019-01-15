var Presupuesto = Presupuesto || {};
Presupuesto.router = new Router('presupuesto');

Presupuesto.IndexView = function(){
    var $table = $('#table');
    var dt;
    var router = Presupuesto.router;

    var _deleteClick = function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        bootbox.dialog({
            message: 'Está a punto de anular el presupuesto ¿Desea continuar?',
            title: 'Confirmar anulación',
            buttons: {
                delete: {
                    label: 'Anular',
                    className: "btn-danger",
                    callback: function() {
                        $.ajax({
                            'url': router.urlFor(id),
                            'type': 'DELETE',
                            'dataType': 'json'
                        }).done(function (result) {
                            if (result.success) {
                                dt.ajax.reload();
                                toastr.success('Se anuló el presupuesto', 'Anulado');
                            } else {
                                toastr.error(result.message, 'Error');
                            }
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            toastr.warning(errorThrown, 'Error interno');
                        });
                    }
                },
                cancel: {
                    label: "Cancelar",
                    className: "btn-default"
                }
            }
        });
    };

    $(function() {
        dt = $table.DataTable({
            serverSide: true,
            order: [[ 0, "desc" ]],
            ajax: router.urlFor('datatable'),
            columns: [
                {
                    data: 'id',
                    className: 'text-right',
                    render: function (data, type, row, meta) {
                        if (type === 'display' && parseInt(row.anulado)) {
                            return data + '<br><span class="label label-danger">Anulado</span>';
                        }
                        return data;
                    }
                },
                { data: 'fecha', className: 'text-right' },
                { data: 'cliente_nombre' },
                { data: 'pedido_id', className: 'text-right' },
                { data: 'total', className: 'text-right' },
                { data: 'accion', sortable: false, searchable: false }
            ]
        });

        $("#toolbar").detach().appendTo('div.toolbar-datatable');
        $table.on('click', 'a.delete', _deleteClick);
        Common.temporalAlert($('#mensaje-exito'));
        Common.temporalAlert($('#mensaje-error'));

        var $selectCliente = $('#clienteId').selectize({
            selectOnTab: true,
        });

        $('#form').validate({
            rules: {
                'clienteId': {
                    required: function (e) {
                        var pedidoId = parseInt($('#pedidoId').val()) || 0;
                        return pedidoId === 0;
                    }
                },
                'pedidoId': {
                    number: true,
                    min: 0,
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $('#modal-nuevo').on('show.bs.modal', function(e) {
            $('#form')[0].reset();
            $selectCliente[0].selectize.clear();
        });
    });
};

Presupuesto.FormView = function() {
    "use strict";
    var router = Presupuesto.router;
    var routerArticulo = new Router('articulo');
    var routerCliente = new Router('cliente');
    var $cliente = $('#cliente');
    var $lineasBody = $('#lineas > tbody');
    var $codigo = $('#codigo');
    var $info = $('#info');
    var $form = $('#form');
    var $total = $("#lbl-total");
    var $saldo = $('#lbl-saldo');
    var $adv = $('#adv');
    var depositoId = 1; // Distribuidora

    function calcularTotal() {
        var total = 0;
        
        $lineasBody.find('tr').each(function(i, row) {
            var cantidad = Common.parseFloat($('input[name="detalle-cantidad[]"]', row).val());
            var precio = Common.parseFloat($('input[name="detalle-precio[]"]', row).val());
            var descuento = Common.parseFloat($('input[name="detalle-descuento[]"]', row).val());
            var precioNeto = Common.round(precio * (1-descuento/100), 2);
            var importe = cantidad * precioNeto;
            
            $('input[name="detalle-importe[]"]', row).val(importe.toFixed(2));

            total += importe;
        });

        $total.html(total.toFixed(2));
    }

    function agregarArticulo(articuloId) {
        var url;
        
        if (articuloId) {
            url = routerArticulo.urlFor('buscar/' + articuloId, {deposito: depositoId});
        } else {
            url = routerArticulo.urlFor('buscarcodigo/' + $codigo.val(), {deposito: depositoId});
        }

        $.getJSON(url)
            .done(function(result) {
                if (result.success) {
                    var articulo = result.data;

                    if (articulo.stock > 0) {
                        var $row = $([
                            '<tr>',
                                '<td>',
                                    '<input type="hidden" name="detalle-articulo-id[]" value="', articulo.id, '">',
                                    '<div class="input-group">',
                                        '<input type="text" class="form-control text-right" name="detalle-codigo[]" value="', articulo.codigo,'" readonly>',
                                        '<span class="input-group-btn">',
                                            ' <a href="#" class="btn btn-danger eliminar">',
                                                '<i class="glyphicon glyphicon-minus"></i>',
                                            '</a>',
                                        '</span>',
                                    '</div>',
                                '</td>',
                                '<td><textarea rows="1" class="form-control" name="detalle-descripcion[]" readonly>', articulo.descripcion, '"</textarea></td>',
                                '<td><input type="text" class="form-control text-right calcular" name="detalle-cantidad[]" value="1" placeholder="0"></td>',
                                '<td><input type="text" class="form-control text-right calcular" name="detalle-precio[]" value="', articulo.precio, '" placeholder="0.00"></td>',
                                '<td><input type="text" class="form-control text-right calcular" name="detalle-descuento[]" value="0.00"></td>',
                                '<td><input type="text" class="form-control text-right" name="detalle-importe[]" value="0.00" readonly></td>',
                            '</tr>'
                        ].join('')).appendTo($lineasBody);

                        $('input[name="detalle-cantidad[]"]', $row).focus().select();
                    } else {
                        Message.showError('No hay stock del artículo ' + articulo.codigo, 'Stock insuficiente');
                    }
                } else {
                    Message.showError('No se encontró el artículo');
                }

                $codigo.val('');
            });
    }

    function controlarStock(row) {
        var articuloId = $('input[name="detalle-articulo-id[]"]', row).val();
        var codigo = $('input[name="detalle-codigo[]"]', row).val();
        var inputCantidad = $('input[name="detalle-cantidad[]"]', row);
        var cantidad = Common.parseFloat(inputCantidad.val());
        inputCantidad.prop('disabled', true);

        $.getJSON(routerArticulo.urlFor('stock'), {
            'articulo': articuloId,
            'deposito': depositoId
        }).done(function(result) {
            if (result.success && cantidad > result.stock) {
                if (result.stock > 0) {
                    Message.showError('Solamente hay ' + result.stock + ' unidades del artículo ' + codigo, 'Stock insuficiente');
                } else {
                    Message.showError('No hay stock del artículo ' + codigo, 'Stock insuficiente');
                }
                inputCantidad.val(0);
                calcularTotal();
            }
        }).always(function() {
            inputCantidad.prop('disabled', false);
        });
    }

    function mostrarCliente(id) {
        $.getJSON(routerCliente.urlFor('buscar/' + id))
            .done(function(result) {
                if (result.success) {
                    var cliente = result.cliente;

                    var lineas = [];
                    lineas.push('<strong>Dirección</strong><br>');
                    lineas.push(cliente.domicilio, ', ', cliente.localidad, '<br><br>');
                    lineas.push('<strong>Grupo</strong><br>');
                    lineas.push(cliente.grupo, ' (-', cliente.descuento.toFixed(2), '%)<br><br>');
                    lineas.push('<strong>Notas</strong><br>', cliente.notas);
                    
                    $info.html(lineas.join(''));

                    if (cliente.adv) {
                        $adv.html('<strong>Advertencia!</strong> ' + cliente.adv);
                        $adv.show();
                    }

                    calcularTotal();
                    $codigo.focus();
                } else {
                    Message.showError(result.message);
                }
            });
    }

    function limpiarCliente() {
        saldo = 0;
        $('#saldo').val('0');
        $info.html('');
        $saldo.html('');
        $adv.html('');
        $adv.hide();
        calcularTotal();
    }

    $(function() {
        $form.validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function(form) {
                Common.submitForm($(form), function(result) {
                    if (result.success) {
                        Common.open(router.urlFor('imprimir/' + result.id), '_blank');
                        Common.redirect(router.root);
                    } else {
                        $('#mensaje').html('<strong>Error!</strong> ' + result.message);
                        $('#mensaje').show();
                    }
                });
            }
        });

        if ($cliente.is('input')) {
            if ($cliente.val()) {
                mostrarCliente(parseInt($cliente.val()));
            }
        } else {
            $cliente.selectize({
                selectOnTab: true,
                onChange: function(value) {
                    limpiarCliente();
                    if (value) {
                        mostrarCliente(parseInt(value));
                    }
                }
            });
        }

        $codigo.keydown(function(e) {
            if((e.which == 13 || e.which == 9) && $(this).val().trim()) {
                e.preventDefault();
                agregarArticulo();
            }
        });

        $lineasBody.on('keypress', 'input[name="detalle-cantidad[]"]:last', function(e){
            if(e.which == 13) {
                $codigo.focus();
            }
        });

        $lineasBody.on('keyup', 'input.calcular', calcularTotal);
        $lineasBody.on('change', 'select.calcular', calcularTotal);
        $lineasBody.on('click', 'a.eliminar', function (e) {
            e.preventDefault();
            $(this).parents('tr').remove();
            calcularTotal();
        });
        $lineasBody.on('change', 'input[name="detalle-cantidad[]"]', function(e) {
            controlarStock($(this).parents('tr'));
        });

        $('#buscar-articulo').on('click', function(e) {
            Modal.Articulos.show({
                onSelect: function(id) {
                    agregarArticulo(id);
                }
            });
        });

        $('#form').on("keyup keypress", Common.preventEnterSubmit);

        calcularTotal();
    });
};
