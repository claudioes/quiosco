App.Pedido = (function () {
    "use strict";

    return {
        Index: function () {
            var $table = $('#table');

            var dt = $table.DataTable({
                serverSide: true,
                order: [[ 0, "desc" ]],
                ajax: App.pathFor('pedido/datatable'),
                columns: [
                    {
                        data: 'id',
                        className: 'text-right',
                        render: function (data, type, row, meta) {
                            if (type === 'display' && parseInt(row.facturado)) {
                                return data + '<br><span class="label label-success">Facturado</span>';
                            }
                            return data;
                        }
                    },
                    { data: 'fecha', className: 'text-right' },
                    { data: 'cliente_id', className: 'text-right' },
                    { data: 'cliente_nombre' },
                    { data: 'accion', sortable: false, searchable: false }
                ]
            });

            $table.on('click', 'a.delete', function(e) {
                e.preventDefault();
                Common.ajaxDelete('pedido', $(this).data('id'));
            });

            $("#toolbar").detach().appendTo('div.toolbar-datatable');
        },

        Form: function () {
            var form = $('#form');
            var lineas = $('#lineas');
            var codigo = $('#codigo');
            var mensaje = $('#mensaje');

            function agregarArticulo(articuloId) {
                var url;

                if (articuloId) {
                    url = App.pathFor('articulo/buscar/' + articuloId);
                } else {
                    url = App.pathFor('articulo/buscarcodigo/' + codigo.val());
                }

                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function(result) {
                        if (result.success) {
                            var articulo = result.data;
                            var row = $([
                                '<tr>',
                                    '<td class="text-right">',
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
                                    '<td><input type="text" class="form-control" name="detalle-descripcion[]" value="', articulo.descripcion, '" readonly></td>',
                                    '<td><input type="text" class="form-control text-right" name="detalle-cantidad[]" value="1"></td>',
                                '</tr>'
                            ].join('')).appendTo(lineas.children('tbody'));

                            $('input[name="detalle-cantidad[]"]:last').focus().select();
                        } else {
                            Message.showError('No se encontró el artículo', 'Error');
                        }
                        codigo.val('');
                    }
                });
            }

            function mostrarCliente(clienteId) {
                var url = App.pathFor('cliente/buscar/'+clienteId);
                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function(result) {
                        if (result.success) {
                            var cliente = result.cliente;
                            var lineas = [];
                            lineas.push('<strong>Dirección</strong><br>');
                            lineas.push(cliente.domicilio, ', ', cliente.localidad, '<br><br>');
                            lineas.push('<br><br><strong>Notas</strong><br>', cliente.notas, '<br><br>');
                            $('#info-cliente').html(lineas.join(''));
                            codigo.focus();
                        } else {
                            Message.showError(result.message);
                        }
                    }
                });
            }

            form.validate({
                submitHandler: function(form) {
                    var btn = $(form).find(':submit');

                    mensaje.hide();
                    btn.prop('disabled', true);

                    Common.submitForm($(form), function(result) {
                        if (result.success) {
                            window.open(App.pathFor('pedido/imprimir/' + result.id), '_blank');
                            window.location.href = App.pathFor('pedido');
                        } else {
                            mensaje.html('<strong>Error!</strong> ' + result.message);
                            mensaje.show();
                            btn.prop('disabled', false);
                        }
                    });
                }
            });

            form.on("keyup keypress", Common.preventEnterSubmit);

            $('#cliente').selectize({
                selectOnTab: true,
                onChange: function(value) {
                    $('#info-cliente').html('');
                    if (value) {
                        mostrarCliente(value);
                    }
                }
            });

            codigo.keydown(function(e) {
                if(e.which == 13 || e.which == 9) {
                    if ($(this).val().trim()) {
                        e.preventDefault();
                        agregarArticulo();
                    }
                }
            });

            lineas.on('keypress', 'input[name="detalle-cantidad[]"]:last', function(e){
                if(e.which == 13) {
                    codigo.focus();
                }
            });

            lineas.on('click', 'a.eliminar', function (e) {
                e.preventDefault();
                $(this).parents('tr').remove();
            });

            $('#btn-buscar-articulo').click(function(e) {
                Modal.Articulos.show({
                    onSelect: function(id) {
                        agregarArticulo(id);
                    }
                });
            });
        },
    };
})();
