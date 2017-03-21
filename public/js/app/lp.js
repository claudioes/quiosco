var LP = LP || {};
LP.router = new Router('lp');

LP.IndexView = function() {
    "use strict";
    var $table = $('#table');
    var router = LP.router;

    var _deleteClick = function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        Common.eliminarDatatable(router.urlFor(id), id);
    };

    var _generadosClick = function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.get(url, function (html) {
            bootbox.dialog({
                onEscape: true,
                backdrop: true,
                size: 'large',
                title: 'Listas de precios generadas',
                message: html,
            });
        });
    };

    $(function() {
        var dt = $table.DataTable({
            serverSide: true,
            ajax: router.urlFor('datatable'),
            order: [[ 0, "desc" ]],
        });

        $("#toolbar").detach().appendTo('div.toolbar-datatable');
        $table.on('click', 'a.delete', _deleteClick);
        $table.on('click', 'a.generados', _generadosClick);
        Common.temporalAlert($('#mensaje'));
    });
};

LP.FormView = function () {
    "use strict";
    var $table = $('#tabla-articulos');
    var $tableBody = $table.children('tbody');
    var router = LP.router;

    $(function() {
        $('form').validate({
            ignore: '*:not([name])',
            rules: {
                grupo: 'required',
                numero: 'required',
                fecha: 'required',
            },
            submitHandler: function(form) {
                var articulos = [];
                $('input:hidden[name="articuloid[]"]').remove();
                $("input:checked", dt.rows().nodes()).each(function() {
                    articulos.push('<input type="hidden" name="articuloid[]" value="', $(this).val(), '">');
                });
                $(articulos.join('')).appendTo(form);

                Common.submitForm($(form), function(result) {
                    if (result.success) {
                        Common.redirect(result.redirect);
                    } else {
                        $('#mensaje').html('<strong>Error!</strong> ' + result.message);
                        $('#mensaje').show();
                    }
                });
            }
        });

        var dt = $table.DataTable({
            rowCallback: function(row, data, index) {
                var $row = $(row);
                if ($row.find(':checkbox')[0].checked) {
                    $row.addClass("success");
                } else {
                    $row.removeClass("success");
                }
            }
        });

        var _seleccionarArticulos = function (valor) {
            // Solamente las filas que correspondan al filtro aplicado
            var rows = dt.rows({ 'search': 'applied' }).nodes();
            $(':checkbox', rows).prop('checked', valor);
            dt.draw();
        };

        $('#btn-articulos-todos').click(function() {
            _seleccionarArticulos(true);
        });

        $('#btn-articulos-ninguno').click(function() {
            _seleccionarArticulos(false);
        });

        $tableBody.on('change', ':checkbox', function(){
            if(this.checked){
                $(this).closest('tr').addClass("success");
            } else {
                $(this).closest('tr').removeClass("success");
            }
        });

        $tableBody.on('click', 'tr', function (e) {
            if (e.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });

        $('#select-familia').on('change', function(e) {
            _filtrar();
        });

        $('#select-marca').on('change', function(e) {
            _filtrar();
        });

        var _filtrar = function () {
            if ($("#select-familia").val()) {
                dt.columns(3).search("^"+$("#select-familia").children(":selected").text()+"$", true, false);
            } else {
                dt.columns(3).search('');
            }

            if ($("#select-marca").val()) {
                dt.columns(4).search("^"+$("#select-marca").children(":selected").text()+"$", true, false);
            } else {
                dt.columns(4).search('');
            }

            dt.draw();
        };

        $("#tbr-seleccionar").detach().appendTo('div.toolbar-datatable');
        $('.datepicker').datepicker();

        tinymce.init({
            selector: '#notas',
            language: 'es',
            theme: 'modern',
            plugins: 'textcolor',
            menubar: false,
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            },
        });
    });
};

LP.GenerarTodosView = function () {
    "use strict";

    $(function() {
        var $tablaResultado = $('#tabla-resultado > tbody');
        var $botonGuardar = $('#boton-generar');

        $('#form').validate({
            ignore: '*:not([name])',
            submitHandler: function(form) {
                $botonGuardar.prop('disabled', true);
                $('#resultado').show();
                $tablaResultado.html('<tr><td colspan="3">Generando...</td></tr>');

                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType:'json',
                }).done(function(result) {
                    if (result.success) {
                        var data = result.data;
                        var rows = [];

                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            rows.push('<tr><td>', d.lista, '</td><td>');

                            if (d.error) {
                                rows.push('<span style="color:#d9534f"><i class="glyphicon glyphicon-warning-sign"></i> ', d.error, '<span></td><td>');
                            } else {
                                rows.push('<span style="color:#5cb85c"><i class="glyphicon glyphicon-ok"></i> OK</span></td><td>');
                            }

                            if (d.file_url) {
                                rows.push('<a href="', d.file_url ,'">Descargar</a></td><tr>');
                            } else {
                                rows.push('</td><tr>');
                            }
                        }

                        $('#numero').prop('disabled', true);
                        $('#fecha').prop('disabled', true);
                        $tablaResultado.html(rows.join(''));
                    }
                }).fail(function(jqXHR, textStatus, errorThrow) {
                    $botonGuardar.prop('disabled', false);
                    $tablaResultado.html('<tr><td colspan="3">Error en el servidor</td></tr>');
                });
            }
        });

        $('.fecha').datepicker();
    });
};

LP.GenerarView = function () {
    "use strict";

    $(function() {
        var $botonGuardar = $('#boton-generar');
        var $errorMessage = $('#error-message');
        $errorMessage.hide();

        $('#form').validate({
            submitHandler: function(form) {
                $errorMessage.hide();
                $botonGuardar.prop('disabled', true);

                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType:'json',
                }).done(function(result) {
                    if (result.success) {
                        var d = result.data[0];
                        if (d.error) {
                            $errorMessage.html(d.error).show();
                            $botonGuardar.prop('disabled', false);
                        } else {
                            $('<a class="btn btn-default" style="margin-right: 15px;" href="' + d.file_url + '">Descargar</a>').insertAfter($botonGuardar);
                            $botonGuardar.hide();
                        }
                    } else {
                        $errorMessage.html(result.message).show();
                    }
                }).fail(function(jqXHR, textStatus, errorThrow) {
                    $botonGuardar.prop('disabled', false);
                    $errorMessage.html("Error en el servidor").show();
                });
            }
        });

        $('.fecha').datepicker();

        tinymce.init({
            selector: '#notas',
            language: 'es',
            theme: 'modern',
            plugins: 'textcolor',
            menubar: false,
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            },
        });
    });
};
