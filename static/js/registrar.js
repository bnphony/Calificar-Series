function registrarUsuario(datos) {
    $.ajax({
        url: 'funciones/usuario-manage.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log("RESPONSE: ", response);
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
        }
    });
}

$(function() {
    $('#dataRegistro').on('submit', function(e) {
        e.preventDefault();
        let data = new FormData(this);
        data.append('action', 'registrar_usuario');
        registrarUsuario(data);
    });
});