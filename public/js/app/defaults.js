$.extend($.fn.dataTable.defaults, {
    "language": {
        "sProcessing":     "Procesando...",
    	"sLengthMenu":     '_MENU_',
    	"sZeroRecords":    "No se encontraron resultados",
    	"sEmptyTable":     "Ningún dato disponible en esta tabla",
    	"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    	"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    	"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    	"sInfoPostFix":    "",
        "search": '<div class="form-group has-feedback">_INPUT_<span class="glyphicon glyphicon-search form-control-feedback"></span></div>',
        "searchPlaceholder": "Buscar...",
    	"sUrl":            "",
    	"sInfoThousands":  ",",
    	"sLoadingRecords": "Cargando...",
    	"oPaginate": {
    		"sFirst":    "Primero",
    		"sLast":     "Último",
    		"sNext":     "Siguiente",
    		"sPrevious": "Anterior"
    	},
    	"oAria": {
    		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
    		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
    	}
    },
    "lengthMenu": [ [10, 50, 100, -1], ["10 registros", "50 registros", "100 registros", "Todos los registros"] ],
    "pageLength": 100,
    "processing": true,
    "autoWidth": false,
    //"stateSave": true,
    "dom": '<"row"<"col-md-12"<"toolbar-datatable"<"filtro-datatable pull-right"lf>>>><"row"<"col-md-12"tr>><"row"<"col-md-12"p>>',
});

$.extend($.fn.datepicker.defaults, {
    format: 'dd/mm/yyyy',
    autoclose: true,
    language: 'es',
    todayHighlight: true,
    keyboardNavigation: false,
    assumeNearbyYear: true,
    orientation: 'bottom',
});

$.validator.setDefaults({
    debug: true,
    ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
    errorElement: "span",
    errorClass: "help-block",
    highlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error');
    },
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
            error.insertAfter(element.parent());
        } else if ($(element).hasClass('selectized')) {
			error.insertAfter($(element).nextAll('.selectize-control'));
        } else {
            error.insertAfter(element);
        }
    }
});

bootbox.setDefaults({
    onEscape: true,
    backdrop: true,
});
