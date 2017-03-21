var Recepcion = Recepcion || {};
Recepcion.router = new Router('recepcion');

Recepcion.IndexView = function(){
    "use strict";
    var table = $('#table');
    var router = Recepcion.router;

        $(function() {
        var dt = table.DataTable({
            serverSide: true,
            order: [[ 0, "desc" ]],
            ajax: router.urlFor('datatable'),
        });

        table.on('click', 'a.delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Common.eliminarDatatable(router.urlFor(id), id);
        });

        table.on('click', 'a.view', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.get(url, function(html) {
                bootbox.dialog({
                    onEscape: true,
                    backdrop: true,
                    size: 'large',
                    message: html
                });
            });
        });

        $("#toolbar").detach().appendTo('div.toolbar-datatable');
        Common.temporalAlert($('#mensaje'));
    });
};

Recepcion.FormView = function() {
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

        if (articuloId) {
            url = router.urlFor('buscar/' + articuloId);
        } else {
            url = router.urlFor('buscarcodigo/' + $codigo.val());
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
                            '<td><input type="text" class="form-control text-right calcular" autocomplete="off" name="detalle-cantidad[]" value="1" placeholder="0"></td>',
                            '<td><input type="text" class="form-control text-right calcular" autocomplete="off" name="detalle-precio[]" value="', articulo.costo ,'" placeholder="0.00"></td>',
                        '</tr>'
                    ].join('')).appendTo($lineasBody);

                    $('input[name="detalle-cantidad[]"]:last').focus().select();
                } else {
                    Message.showError('No se encontró el artículo');
                }
                $codigo.val('');
            }
        });
    }

    function mostrarProveedor(proveedorId) {
        var router = new Router('proveedor');
        var url = router.urlFor('buscar/'+proveedorId);
        $.ajax({
            url: url,
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    var proveedor = result.data;
                    $('#info').html([
                        '<strong>Dirección</strong><br>',
                        proveedor.domicilio, ', ', proveedor.localidad, '<br><br>',
                        '<strong>Notas</strong><br>',
                        proveedor.notas
                    ].join(''));
                } else {
                    Message.showError(result.message);
                }
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
                var router = Recepcion.router;
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

        $('#proveedor').selectize({
            selectOnTab: true,
            onChange: function(value) {
                $('#info').html('');
                if (value) {
                    mostrarProveedor(value);
                }
            }
        });

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

        $('.fecha').datepicker();
    });
};
