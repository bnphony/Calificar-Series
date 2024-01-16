function iniciarSesion(datos) {
    $.ajax({
        url: 'funciones/auth.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.status === 'ok') {
                location.href = 'inicio.php';
            } else {
                alert("Usuario o Password Incorrectos");
            }
        },
        error: function(xhr, status, error) {
            console.log("Request failed with status: ", status);
        }

    });
}

$(function() {

    $('#dataLogin').on('submit', function(e) {
        e.preventDefault();
        let data = new FormData(this);
        iniciarSesion(data);
    });

    // Attach click event to the toggle password button
    $("#togglePassword").on("click", function () {
        togglePassword();
    });

});

function togglePassword() {
    const passwordInput = $("#id-password");
    const toggleButton = $("#togglePassword");

    // Toggle the type attribute of the password input
    if (passwordInput.attr("type") === "password") {
        passwordInput.attr("type", "text");
        toggleButton.html('<i class="fa-solid fa-eye-slash text-dark"></i>');
    } else {
        passwordInput.attr("type", "password");
        toggleButton.html('<i class="fa-solid fa-eye text-dark"></i>');
    }
}