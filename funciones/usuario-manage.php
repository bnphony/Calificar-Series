<?php 
require_once '../clases/usuario.class.php';
require_once '../clases/respuestas.class.php';

$_usuario = new usuario;
// Se usa $_variable -> para explicar que es una instancia a otra clase
$_respuestas = new respuestas;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'registrar_usuario') {
            if (isset($_POST['usuario']) && isset($_POST['password'])) {
                $postBody = array();
                $postBody['usuario'] = $_POST['usuario'];
                $postBody['password'] = $_POST['password'];
                $datosArray = $_usuario->registrarUsuario($postBody);
                // Devolvemos una Respuesta
                header('Content-Type: application/json'); // Devuelve un objeto JSON de javascript
                if (isset($datosArray["result"]["error_id"])) {
                    $responseCode = "El usuario ya existe!";
                    // http_response_code($responseCode);
                    echo json_encode($responseCode);
                } else {      
                    http_response_code(200);
                    echo json_encode($datosArray);
                }
                
            }
        }
    } else {
        header('Content-Type: application/json');
        $datosArray = $_respuestas->error_405();
        echo json_encode($datosArray);
    }
}

?>