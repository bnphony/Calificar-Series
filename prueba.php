<?php 
require_once "clases/series.class.php";

$_series = new series;

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
       
        
        if (isset($_GET["page"])) {
            $pagina = $_GET["page"];
            $listaSeries = $_series->listaSeries($pagina);
            header("Content-Type: application/json");
            echo json_encode($listaSeries);
            // echo "FUNCIONA";
            http_response_code(200);
        }
        $result = $_series->listaSeries(1);
                
    } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Recibimos los datos enviados
        $postBody = file_get_contents("php://input");
        // Enviamos los datos al manejador
        $datosArray = $_series->addSerie($postBody);
        // Devolvemos una respuesta
        header('Content-Type: application/json');
        if (isset($datosArray["result"]["error_id"])) {
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        } else {
            http_response_code(200);
        }
        echo json_encode($datosArray);
    
    }
?>