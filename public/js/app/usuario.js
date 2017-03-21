var Usuario = Usuario || {};
Usuario.router = new Router('usuario');

Usuario.IndexView = function() {
    "use strict";
    var router = Usuario.router;
    var $table = $('#table');

    $(function() {
        var dt = $table.DataTable({
            serverSide: true,
            ajax: router.urlFor('datatable'),
        });

        $("#toolbar").detach().appendTo('div.toolbar-datatable');
        $table.on('click', 'a.delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Common.eliminarDatatable(router.urlFor(id), id);
        });
    });
};

Usuario.FormView = function() {
    "use strict";
    var router = Usuario.router;
    var $form = $('#form');
    var $permisos = $('#permisos');

    $(function() {
        $form.validate({
            rules: {
                usuario: 'required',
                nombre: 'required',
                apellido: 'required',
                password: {
                    required: true,
                    minlength: 4
                },
                repeticion:  {
                    equalTo: "#password"
                }
            },
            messages: {
                usuario: "Ingrese un nombre de usuario",
                nombre: "Ingrese el nombre",
                apellido: "Ingrese el apellido",
                password: {
                    required: "Ingrese la nueva contraseña",
                    minlength: 'La repetición de la contraseña no coincide'
                },
                repeticion: "Vuelva a repetir la nueva contraseña",
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

        $permisos.on('change', ':checkbox', function(){
            if(this.checked){
                $(this).closest('tr').addClass("success");
            } else {
                $(this).closest('tr').removeClass("success");
            }
        });

        $permisos.on('click', 'tr', function (e) {
            if (e.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });

        $('#admin').on('change', function(e) {
            if ($(this).val() == '1') {
                $permisos.hide();
            } else {
                $permisos.show();
            }
        });
    });
};

Usuario.PasswordView = function() {
    "use strict";
    var $form = $('#form');

        $(function() {
        $form.validate({
            rules: {
                password: {
                    required: true,
                    minlength: 4
                },
                repeticion:  {
                    equalTo: "#password"
                }
            },
            messages: {
                password: {
                    required: "Ingrese la nueva contraseña",
                    minlength: 'La contraseña debe tener al menos 4 caracteres'
                },
                repeticion: "La repetición de la contraseña no coincide",
            },
            submitHandler: function(form) {
                Common.submitForm($(form), function(result) {
                    if (result.success) {
                        Common.redirect(Usuario.router.root);
                    } else {
                        $('#mensaje').html('<strong>Error!</strong> ' + result.message);
                        $('#mensaje').show();
                    }
                });
            }
        });
    });
};
