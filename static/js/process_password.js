
function resetPassword(datos) {
    $.ajax({
        url: 'process-reset-password.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        success: function(response) {
            respuesta = JSON.parse(response);
            if (respuesta.estado) {
                console.log("SE actualizo correctamente")
                location.href = '../login.php';
            } else {

                console.log("entro");
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
    $('#dataReset').on('submit', function(e) {
        e.preventDefault();
        let data = new FormData(this);
        resetPassword(data);
    });

    $('.btn-close').on('click', function() {
        console.log("funcionao");
        $('.alerta').removeClass('d-block');
    });

    $(".togglePassword").on("click", function () {
        let idPadre = $(this).siblings('input').attr('id');
        const passwordInput = $(`#${idPadre}`);
        // Toggle the type attribute of the password input
        if (passwordInput.attr("type") === "password") {
            passwordInput.attr("type", "text");
            $(this).html('<i class="fa-solid fa-eye-slash text-dark"></i>');
        } else {
            passwordInput.attr("type", "password");
            $(this).html('<i class="fa-solid fa-eye text-dark"></i>');
        }
        console.log("funciona");
    });
});


function togglePassword(idElement) {
    const passwordInput = $(`#${idElement}`);
    const toggleButton = $(".togglePassword");

    // Toggle the type attribute of the password input
    if (passwordInput.attr("type") === "password") {
        passwordInput.attr("type", "text");
        toggleButton.html('<i class="fa-solid fa-eye-slash text-dark"></i>');
    } else {
        passwordInput.attr("type", "password");
        toggleButton.html('<i class="fa-solid fa-eye text-dark"></i>');
    }
}