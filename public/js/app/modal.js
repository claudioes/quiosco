var Modal = Modal || {};

Modal.Articulos = (function() {
    "use strict";

    var dialog = $([
        '<div class="modal fade" id="modal-articulos" tabindex="-1" role="dialog">',
            '<div class="modal-dialog">',
                '<div class="modal-content">',
                    '<div class="modal-header">',
                        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>',
                        '<h4 class="modal-title" id="titulo-modal-articulos">Seleccionar artículo</h4>',
                    '</div>',
                    '<div class="modal-body"></div>',
                '</div>',
            '</div>',
        '</div>',
    ].join(''));

    var tabla = $([
        '<table class="table table-hover" id="tabla-modal-articulos">',
            '<thead><tr>',
                '<th>Código</th>',
                '<th>Descripción</th>',
                '<th>Precio</th>',
                '<th>Acción</th>',
            '</tr></thead>',
            '<tbody><tr>',
                '<td colspan="4" class="text-center">Sin resultados</td>',
            '</tr></tbody>',
        '</table>',
    ].join(''));

    var filtro = $([
        '<div class="form-group has-feedback">',
            '<input type="text" id="filtro-modal-articulos" class="form-control" placeholder="Ingrese el código o parte de la descripción para buscar" autocomplete="off">',
            '<span class="glyphicon glyphicon-search form-control-feedback"></span>',
        '</div>',
    ].join(''));

    var input = filtro.find(':input');
    var modalBody = dialog.find('.modal-body');
    var container = $('body');
    var rowSinResultados = '<tr><td colspan="4" class="text-center">Sin resultados</td></tr>';
    var rowBuscando = '<tr><td colspan="4" class="text-center">Buscando...</td></tr>';
    var timer;
    var inputAnterior;
    var callback;

    var _mostrar = function(){
        var limite = 100;
        var router = new Router('articulo');
        var tableBody = tabla.children('tbody');
        var textoFiltro = input.val().trim();

        if (textoFiltro) {
            tableBody.html(rowBuscando);
            $.ajax({
                url: router.urlFor('todos'),
                data: {
                    'q': textoFiltro,
                    'l': limite,
                },
                dataType: 'json',
                success: function(result) {
                    var data = result.data;

                    if (data.length) {
                        var rows = [];

                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            rows[i] = [
                                '<tr>',
                                    '<td>', d.codigo, '</td>',
                                    '<td style="width:100%">', d.descripcion, '</td>',
                                    '<td class="text-right">', d.precio, '</td>',
                                    '<td><button type="button" class="btn btn-default" data-id="', d.id, '">Seleccionar</button>',
                                '</tr>'
                            ].join('');
                        }

                        tableBody.html(rows.join(''));
                    } else {
                        tableBody.html(rowSinResultados);
                    }
                }
            });
        } else {
            tableBody.html(rowSinResultados);
        }
    };

    var _iniciar = function () {
        input.keyup(function() {
            var textoFiltro = $(this).val().trim();
            if (inputAnterior != textoFiltro) {
                inputAnterior = textoFiltro;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    _mostrar(textoFiltro);
                }, 400);
            }
        });

        tabla.on('click', 'button', function(e) {
            e.stopPropagation();
            e.preventDefault();

            if (callback) {
                callback($(this).data('id'));
            }

            dialog.modal('hide');
        });

        // clear the existing handler focusing the submit button...
        dialog.off("shown.bs.modal");

        // ...and replace it with one focusing our input, if possible
        dialog.on("show.bs.modal", function() {
            input.val('');
            _mostrar();
        });

        dialog.on("shown.bs.modal", function() {
            // need the closure here since input isn't
            // an object otherwise
            input.focus();
        });

        dialog.on("hidden.bs.modal", function(e) {
            // ensure we don't accidentally intercept hidden events triggered
            // by children of the current dialog. We shouldn't anymore now BS
            // namespaces its events; but still worth doing
            if (e.target === this) {
                dialog.remove();
            }
        });
    };

    var show = function(options) {
        callback = options.onSelect;

        _iniciar();
        modalBody.append(filtro);
        modalBody.append(tabla);
        container.append(dialog);
        dialog.modal('show');
    };

    return {
        show: show,
    };
})();
