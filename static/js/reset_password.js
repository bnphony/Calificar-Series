
function resetPassword(datos) {
    $.ajax({
        url: 'funciones/password-manage.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        success: function(response) {
            respuesta = JSON.parse(response);
            if (respuesta.estado) {
                console.log("SE actualizo correctamente")
                location.href = respuesta.url;
            } else {
                $('.error-message').text(respuesta.mensaje);
                $('.alerta').addClass('d-block');
            }
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
        }

    });
}
$(function() {
    $('#dataResetEmail').on('submit', function(e) {
        e.preventDefault();
        let data = new FormData(this);
        resetPassword(data);
    });

    $('.btn-close').on('click', function() {
        $('.alerta').removeClass('d-block');
    });
});
