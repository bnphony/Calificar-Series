<?php 
session_start();
require_once '../clases/auth.class.php';
require_once '../clases/respuestas.class.php';

$_auth = new auth;
// Se usa $_variable -> para explicar que es una instancia a otra clase
$_respuestas = new respuestas;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['usuario']) && isset($_POST['password'])) {
        $postBody = array();
        $postBody['usuario'] = $_POST['usuario'];
        $postBody['password'] = $_POST['password'];
        $datosArray = $_auth->login($postBody);
        
        // Devolvemos una Respuesta
        header('Content-Type: application/json'); // Devuelve un objeto JSON de javascript
        if (isset($datosArray["result"]["error_id"])) {
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
            echo json_encode($responseCode);
        } else {      

            $_SESSION['usuario'] = "ok";
            $_SESSION['nombreUsuario'] = $datosArray['result'];
            $_SESSION['usuarioId'] = $datosArray['usuarioId'];
            http_response_code(200);
            // json_encode => convierte arrays en STRINGS
            echo json_encode($datosArray);
        }
    }
    
} else {
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>