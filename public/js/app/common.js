var Common = (function() {
    "use strict";
    return {
        open: function(url, params) {
            if (params) {
                url += '?' + $.param(params);
            }
            window.open(url);
        },
        replaceUrl: function(url) {
            window.location.replace(url);
        },
        redirect: function(url) {
            window.location.href = url;
        },
        temporalAlert: function(el) {
            el.alert();
            window.setTimeout(function() {
                el.fadeTo(500, 0).slideUp(200, function(){
                    $(this).alert('close');
                });
            }, 5000);
        },
        eliminarDatatable: function(url, id) {
            //console.log(url);
            bootbox.dialog({
                message: 'Está a punto de eliminar permanentemente este registro ¿Desea continuar?',
                title: 'Confirmar eliminación',
                buttons: {
                    delete: {
                        label: 'Eliminar',
                        className: "btn-danger",
                        callback: function() {
                            var $row = $('#row_' + id);
                            $.ajax({
                                'url': url,
                                'type': 'DELETE',
                                'dataType': 'json',
                                'success': function(result) {
                                    if (result.success) {
                                        if ($row) {
                                            $row.fadeOut(500, function(){
                                                $row.remove();
                                            });
                                        }
                                        toastr.success('Se eliminó el registro', 'Eliminado');
                                    } else {
                                        toastr.error(result.message, 'Error');
                                    }
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
        },
        confirm: function(message, callback) {
            bootbox.dialog({
                message: message,
                title: 'Confirmación',
                buttons: {
                    ok: {
                        label: 'Continuar',
                        className: "btn-success",
                        callback: function() {
                            callback(true);
                        }
                    },
                    cancel: {
                        label: "Cancelar",
                        className: "btn-default",
                        callback: function() {
                            callback(false);
                        }
                    }
                }
            });
        },
        submitForm: function(el, handler) {
            $.ajax({
                type: el.attr('method'),
                url: el.attr('action'),
                data: el.serialize(),
                dataType: 'json',
                success: function(result) {
                    handler(result);
                }
            });
        },
        ajaxSubmit: function (sel) {
            var $el = $(sel);
            return $.ajax({
                type: $el.attr('method'),
                url: $el.attr('action'),
                data: $el.serialize(),
                dataType: 'json',
            });
        },
        parseFloat: function(value) {
            if (value) {
                return parseFloat(String(value).replace(',','')) || 0;
            }
            return 0;
        },
        preventEnterSubmit: function(e)  {
            var code = e.keyCode || e.which;
            if (code == 13 && e.target.nodeName != "TEXTAREA") {
                e.preventDefault();
            }
        },
        round: function(value, decimals) {
        	return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
        },
        padLeft: function (n,str){
            return Array(n-String(this).length+1).join(str||'0')+this;
        }
    };
})();
