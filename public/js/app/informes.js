var Informes = Informes || {};

Informes = (function() {
    "use strict";

    var _renderErrors = function (errors) {
        return '<strong>Error!</strong><br><ul><li>' + errors.join('</li><li>') + '</li></ul>';
    };

    var _loadArticulosGenerados = function ($div) {
        $.get('articulos/generados', function (result) {
            $div.html(result);
        });
    };

    var initDescuentos = function() {
        var $submitButtons = $('button[type="submit"]');
        var $error = $('#errores');
        var $informe = $('#informe');

        $error.hide();
        $informe.hide();

        $('.input-daterange').datepicker();

        $('.selectize').selectize();

        $("#form").validate({
            submitHandler: function(form) {
                $error.hide();
                $informe.hide();
                $submitButtons.prop('disabled', true);

                Common.ajaxSubmit(form)
                    .done(function (result) {
                        if (result.success) {
                            $informe.html(result.html).fadeIn();
                        } else {
                            $error.html(_renderErrors(result.errors)).fadeIn();
                        }
                    }).always(function (result) {
                        $submitButtons.prop('disabled', false);
                    });
            }
        });
    };

    var initDepositos = function() {
        var $submitButtons = $('button[type="submit"]');
        var $error = $('#errores');
        var $informe = $('#informe');

        $error.hide();
        $informe.hide();

        $('.input-daterange').datepicker();

        $('.selectize').selectize();

        $("#form").validate({
            submitHandler: function(form) {
                $error.hide();
                $informe.hide();
                $submitButtons.prop('disabled', true);

                Common.ajaxSubmit(form)
                    .done(function (result) {
                        if (result.success) {
                            $informe.html(result.html).fadeIn();
                        } else {
                            $error.html(_renderErrors(result.errors)).fadeIn();
                        }
                    }).always(function (result) {
                        $submitButtons.prop('disabled', false);
                    });
            }
        });
    };

    var initArticulos = function() {
        var $submitButtons = $('button[type="submit"]');
        var $error = $('#errores');
        var $informe = $('#informe');
        var $generados = $('#generados');
        var $tabGenerados = $('.nav-tabs a[href="#generados"]');

        $error.hide();
        $informe.hide();

        $('.selectize').selectize({
            plugins: [
                'remove_button',
            ],
        });

        $('.input-daterange').datepicker();

        $("#form").validate({
            submitHandler: function(form) {
                $submitButtons.prop('disabled', true);
                $error.hide();
                $informe.hide();

                Common.ajaxSubmit(form)
                    .done(function (result) {
                        if (result.success) {
                            if (result.url) {
                                window.open(result.url);
                                $tabGenerados.tab('show');
                            } else if (result.html) {
                                $informe.html(result.html).fadeIn();
                            }
                        } else {
                            $error.html(_renderErrors(result.errors)).fadeIn();
                        }
                    })
                    .always(function () {
                        $submitButtons.prop('disabled', false);
                    });
            }
        });

        $tabGenerados.on('show.bs.tab', function (e) {
            _loadArticulosGenerados($generados);
        });
    };

    return {
        initDescuentos: initDescuentos,
        initDepositos: initDepositos,
        initArticulos: initArticulos,
    };
})();
