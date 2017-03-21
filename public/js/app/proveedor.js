var Proveedor = Proveedor || {};
Proveedor.router = new Router('proveedor');

Proveedor.FormView = function() {
    var router = Proveedor.router;
    var $documentos = $('#documentos');
    var $proveedorId = $('#id');
    var $modalDocumento = $('#modal-documento');

    var _mostrarDocumentos = function() {
        if ($proveedorId.length && $proveedorId.val()) {
            $documentos.load(router.urlFor($proveedorId.val() + '/documento'), function() {
                $('.eliminar-documento').click(_eliminarDocumento);
            });
        }
    };

    var _eliminarDocumento = function(e) {
        var url = $(this).attr('href');
        $(this).addClass('disabled');
        $.ajax({
            'url': url,
            'type': 'DELETE',
            'dataType': 'json',
            'success': function(result) {
                if (result.success) {
                    _mostrarDocumentos();
                    toastr.success("Se eliminó el documento seleccionado");
                } else {
                    toastr.error(result.message, 'Error');
                }
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            toastr.warning(errorThrown, 'Error interno');
        });
        e.preventDefault();
    };

    var _buscarCuit = function(e) {
        var cuit = $('#cuit').val().trim().replace('-', '');
        var el = $(e.target);

        el.prop('disabled', true);

        if (cuit) {
            $.ajax({
                url: 'https://soa.afip.gob.ar/sr-padron/v2/persona/' + cuit,
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        var persona = result.data;
                        var domicilio = persona.domicilioFiscal;

                        $('#razon').val(persona.nombre);
                        $('#nombre').val(persona.nombre);

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
                    el.prop('disabled', false);
                }
            });
        }
    };

    $(function() {
        $('#form').validate({
            rules: {
                nombre: 'required',
            },
            messages: {
                nombre: "Ingrese un nombre válido",
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

        $('#form-documento').validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function(form) {
                var botonGuardar = $('#btn-documento-guardar');
                var botonCancelar = $('#btn-documento-cancelar');
                var divMensaje = $('#mensaje-documento');
                var divProgreso = $('#progreso');
                var divBarra = $('#progreso-barra');

                botonGuardar.prop('disabled', true);
                botonCancelar.prop('disabled', true);
                divMensaje.hide();
                divBarra.css('width', '0%');
                divProgreso.show();

                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                // console.log(percentComplete);

                                divBarra.css('width', percentComplete + '%');

                                // if (percentComplete === 100) {
                                //     $('#progreso').addClass('progress-bar-success');
                                // }
                            }
                        }, false);

                        return xhr;
                    },
                    url: $(form).attr('action'),
                    type: $(form).attr('method'),
                    data: new FormData($(form)[0]),
                    processData: false,
                    contentType: false,
                    dataType: 'json'
                })
                .done(function(result) {
                    if (result.success) {
                        $modalDocumento.modal('hide');
                        _mostrarDocumentos();
                    } else {
                        divMensaje.html('<strong>Error!</strong> ' + result.message);
                        divMensaje.show();
                    }
                })
                .always(function() {
                    botonGuardar.prop('disabled', false);
                    botonCancelar.prop('disabled', false);
                    divBarra.css('width', '0%');
                    divProgreso.hide();
                });
            }
        });

        $('.fecha').datepicker();
        $('#btn-buscar-cuit').click(_buscarCuit);
        $modalDocumento.on('show.bs.modal', function(e) {
            $('#form-documento')[0].reset();
        });
        _mostrarDocumentos();
    });
};

Proveedor.IndexView = function() {
    var $table = $('#table');
    var router = Proveedor.router;

        $(function() {
        var dt = $table.DataTable({
            serverSide: true,
            order: [[ 0, "desc" ]],
            ajax: router.urlFor('datatable'),
        });

        $table.on('click', 'a.delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Common.eliminarDatatable(router.urlFor(id), id);
        });

        $("#toolbar").detach().appendTo('div.toolbar-datatable');
        Common.temporalAlert($('#mensaje'));
    });
};
