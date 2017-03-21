var Stock = Stock || {};
Stock.router = new Router('stock');

Stock.MovimientoForm = function() {
    "use strict";
    var _router = new Router('stock');
    var _routerArticulo = new Router('articulo');

    function _agregarArticulo(articuloId) {
        var $lineasBody = $('#lineas').children('tbody');
        var $deposito = $('#deposito');
        var $codigo = $('#codigo');

        var depositoId = parseInt($deposito.val());
        var data = {};
        if (depositoId) {
            data.deposito = depositoId;
        }

        var url = '';
        if (articuloId) {
            url = _routerArticulo.urlFor('buscar/' + articuloId, data);
        } else {
            url = _routerArticulo.urlFor('buscarcodigo/' + $codigo.val(), data);
        }

        $.ajax({
            url: url,
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    var articulo = result.data;

                    var $row = $([
                        '<tr><td class="text-right">',
                            '<input type="hidden" name="detalle-articulo-id[]" value="', articulo.id, '">',
                            '<div class="input-group">',
                                '<input type="text" class="form-control text-right" name="detalle-codigo[]" value="', articulo.codigo,'" readonly>',
                                '<span class="input-group-btn">',
                                    ' <a href="#" class="btn btn-danger btn-delete">',
                                        '<i class="glyphicon glyphicon-minus"></i>',
                                    '</a>',
                                '</span>',
                            '</div>',
                        '</td>',
                        '<td><input type="text" class="form-control" name="detalle-descripcion[]" value="', articulo.descripcion, '" readonly></td>',
                        '<td><input type="text" class="form-control text-right" name="detalle-entrada[]" value="0"></td>',
                        '<td><input type="text" class="form-control text-right" name="detalle-salida[]" value="0"></td></tr>',
                    ].join(''));

                    $lineasBody.append($row);
                    $row.find('input[name="detalle-entrada[]"]').focus().select();
                } else {
                    Message.showError('No se encontró el artículo', 'Error');
                }

                // Si deshabilito el select directamente, no se envía al hacer submit
                $deposito.find('option:not(:selected)').prop('disabled', true);
                $codigo.val('');
            }
        });
    }

    $(function() {
        var $form = $('#form');
        var $codigo = $('#codigo');
        var $mensaje = $('#mensaje');
        var $deposito = $('#deposito');
        var $lineas = $('#lineas');

        $form.validate({
            submitHandler: function(form) {
                var $btn = $(form).find(':submit');

                $mensaje.hide();
                $btn.prop('disabled', true);

                Common.submitForm($(form), function(result) {
                    if (result.success) {
                        Common.redirect(_routerArticulo.root);
                    } else {
                        $mensaje.html('<strong>Error!</strong> ' + result.message);
                        $mensaje.show();
                        $btn.prop('disabled', false);
                    }
                });
            }
        });

        $form.on("keyup keypress", Common.preventEnterSubmit);

        $codigo.keydown(function (e) {
            if((e.which == 13 || e.which == 9) && $(this).val()) {
                if ($deposito.val()) {
                    e.preventDefault();
                    _agregarArticulo();
                } else {
                    Message.showError('Seleccione un deposito');
                }
            }
        });

        $lineas.on('keypress', 'input[name="detalle-entrada[]"]:last', function (e) {
            if(e.which == 13) {
                $codigo.focus();
            }
        });

        $lineas.on('keypress', 'input[name="detalle-salida[]"]:last', function (e) {
            if(e.which == 13) {
                $codigo.focus();
            }
        });

        $lineas.on('click', '.btn-delete', function (e) {
            $(this).parents('tr').remove();
        });

        $('#btn-buscar-articulo').click(function(e) {
            if ($deposito.val()) {
                Modal.Articulos.show({
                    onSelect: function(id) {
                        _agregarArticulo(id);
                    }
                });
            } else {
                Message.showError('Seleccione un deposito');
            }
        });
    });
};

Stock.InventarioView = function() {
    "use strict";
    var $form = $('#form');
    var $lineas = $('#lineas');
    var $lineasBody = $lineas.children('tbody');
    var $codigo = $('#codigo');
    var $mensaje = $('#mensaje');
    var $deposito = $('#deposito');

    function agregarArticulo(articuloId) {
        var url;
        var router = new Router('articulo');
        var depositoId = parseInt($deposito.val());
        var data = {};

        if (depositoId) {
            data.deposito = depositoId;
        }

        if (articuloId) {
            url = router.urlFor('buscar/' + articuloId, data);
        } else {
            url = router.urlFor('buscarcodigo/' + $codigo.val(), data);
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
                            '<td><input type="text" class="form-control" autocomplete="off" name="detalle-descripcion[]" value="', articulo.descripcion, '" readonly></td>',
                            '<td><input type="text" class="form-control text-right" autocomplete="off" name="detalle-stock[]" value="', articulo.stock.toFixed(2) ,'" readonly></td>',
                            '<td><input type="text" class="form-control text-right" autocomplete="off" name="detalle-cantidad[]" value="1" placeholder="0"></td>',
                        '</tr>'
                    ].join('')).appendTo($lineasBody);

                    $('input[name="detalle-cantidad[]"]:last').focus().select();
                } else {
                    Message.showError('No se encontró el artículo', 'Error');
                }
                $deposito.prop('disabled', true);
                $codigo.val('');
            }
        });
    }

    $(function() {
        $form.validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function(form) {
                var router = new Router('articulo');
                var btn = $(form).find(':submit');

                $mensaje.hide();
                btn.prop('disabled', true);

                Common.submitForm($(form), function(result) {
                    if (result.success) {
                        Common.redirect(router.root);
                    } else {
                        $mensaje.html('<strong>Error!</strong> ' + result.message);
                        $mensaje.show();
                        btn.prop('disabled', false);
                    }
                });
            }
        });

        $form.on("keyup keypress", Common.preventEnterSubmit);

        $codigo.keydown(function(e) {
            if(e.which == 13 || e.which == 9) {
                if ($deposito.val()) {
                    if ($(this).val().trim()) {
                        e.preventDefault();
                        agregarArticulo();
                    }
                } else {
                    Message.showError('Debe seleccionar un deposito para agregar artículos');
                }
            }
        });

        $lineas.on('keypress', 'input[name="detalle-cantidad[]"]:last', function(e){
            if(e.which == 13) {
                $codigo.focus();
            }
        });

        $lineas.on('click', 'a.eliminar', function (e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        });

        $('#btn-buscar-articulo').click(function(e) {
            if ($deposito.val()) {
                Modal.Articulos.show({
                    onSelect: function(id) {
                        agregarArticulo(id);
                    }
                });
            } else {
                Message.showError('Debe seleccionar un deposito para agregar artículos');
            }
        });

        $deposito.change(function(e) {
            $('#deposito-id').val($(this).val());
        });
    });
};

Stock.TransferenciaView = function() {
    "use strict";
    var $form = $('#form');
    var $lineas = $('#lineas');
    var $lineasBody = $lineas.children('tbody');
    var $codigo = $('#codigo');
    var $mensaje = $('#mensaje');
    var $depositoOrigen = $('#origen');
    var $depositoDestino = $('#destino');

    function agregarArticulo(articuloId) {
        var url;
        var router = new Router('articulo');
        var depositoId = parseInt($depositoOrigen.val());
        var data = {};

        if (depositoId) {
            data.deposito = depositoId;
        }

        if (articuloId) {
            url = router.urlFor('buscar/' + articuloId, data);
        } else {
            url = router.urlFor('buscarcodigo/' + $codigo.val(), data);
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
                            '<td><input type="text" class="form-control" autocomplete="off" name="detalle-descripcion[]" value="', articulo.descripcion, '" readonly></td>',
                            '<td><input type="text" class="form-control text-right" autocomplete="off" name="detalle-stock[]" value="', articulo.stock.toFixed(2) ,'" readonly></td>',
                            '<td><input type="text" class="form-control text-right" autocomplete="off" name="detalle-cantidad[]" value="1" placeholder="0"></td>',
                        '</tr>'
                    ].join('')).appendTo($lineasBody);

                    $('input[name="detalle-cantidad[]"]:last').focus().select();
                } else {
                    Message.showError('No se encontró el artículo', 'Error');
                }
                $depositoOrigen.prop('disabled', true);
                $depositoDestino.prop('disabled', true);
                $codigo.val('');
            }
        });
    }

    $(function() {
        $form.validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function(form) {
                var router = new Router('articulo');
                var btn = $(form).find(':submit');

                $mensaje.hide();
                btn.prop('disabled', true);

                Common.submitForm($(form), function(result) {
                    if (result.success) {
                        Common.redirect(router.root);
                    } else {
                        $mensaje.html('<strong>Error!</strong> ' + result.message);
                        $mensaje.show();
                        btn.prop('disabled', false);
                    }
                });
            }
        });

        $form.on("keyup keypress", Common.preventEnterSubmit);

        $codigo.keydown(function(e) {
            if(e.which == 13 || e.which == 9) {
                if ($depositoOrigen.val() && $depositoDestino.val()) {
                    if ($(this).val().trim()) {
                        e.preventDefault();
                        agregarArticulo();
                    }
                } else {
                    Message.showError('Debe seleccionar un deposito de origen y un deposito de destino para agregar artículos');
                }
            }
        });

        $lineas.on('keypress', 'input[name="detalle-cantidad[]"]:last', function(e){
            if(e.which == 13) {
                $codigo.focus();
            }
        });

        $lineas.on('click', 'a.eliminar', function (e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        });

        $('#btn-buscar-articulo').click(function(e) {
            if ($depositoOrigen.val() && $depositoDestino.val()) {
                Modal.Articulos.show({
                    onSelect: function(id) {
                        agregarArticulo(id);
                    }
                });
            } else {
                Message.showError('Debe seleccionar un deposito de origen y un deposito de destino para agregar artículos');
            }
        });

        $depositoOrigen.change(function(e) {
            $('#deposito-origen-id').val($(this).val());
        });

        $depositoDestino.change(function(e) {
            $('#deposito-destino-id').val($(this).val());
        });
    });
};
