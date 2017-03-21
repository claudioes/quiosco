var Message = (function() {
    return {
        showSuccess: function (message, title) {
            title = title || 'Exito!';
            toastr.success(message, title);
        },
        showError: function (message, title) {
            title = title || 'Error!';
            toastr.error(message, title);
        },
        showWarning: function (message, title) {
            title = title || 'Atención!';
            toastr.warning(message, title);
        },
    };
})();
