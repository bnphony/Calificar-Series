<?php 
session_start();
require_once "../clases/series.class.php";

$_series = new series;


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'registrar_anime') {
            $postBody = array();
            foreach ($_POST as $key => $value) {
                // Process each field received via FormData
                $postBody[$key] = $value;
            }
            $postBody['id_categoria'] = $_SESSION['id_categoria'];
            if ($_FILES['logo']['error'] === UPLOAD_ERR_INI_SIZE) {
                // Handle the file size error
                echo 'Error_Max';
            } else {
                foreach ($_FILES as $key => $value) {
                    $postBody[$key] = $value;
                }
                $datosArray = $_series->addSerie($postBody);
                echo "Agregado " . json_encode($datosArray);
            }
        } else if ($_POST['action'] == 'actualizar_anime') {
            
            $postBody = array();
            foreach ($_POST as $key => $value) {
                // Process each field received via FormData
                $postBody[$key] = $value;
            } 
            if ($_FILES['config-logo']['error'] === UPLOAD_ERR_INI_SIZE) {
                // Handle the file size error
                echo 'Error_Max';
            } else {
                foreach ($_FILES as $key => $value) {
                    $postBody[$key] = $value;
                }  
                $datosArray = $_series->actualizarInfoAnime($postBody);
                echo "Actualizado " . json_encode($datosArray);
            }
        } else if ($_POST['action'] == 'eliminar_serie') {
            if (isset($_POST['id_serie'])) {
                $respuesta = $_series->eliminarSerie($_POST['id_serie']);
                if ($respuesta) {
                    echo json_encode($respuesta);
                } else {
                    echo 'Error! No se pudo eliminar la serie';
                }
            }
        }
        
    }
}
    

?>