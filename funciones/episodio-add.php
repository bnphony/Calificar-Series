<?php 
require_once "../clases/series.class.php";

$_series = new series;


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['serieId'])) {
        $respuesta = $_series->addEpisodio($_POST['serieId']);
        if ($respuesta) {
            echo json_encode($respuesta);
        } else {
            echo 'Error! No se agrego un nuevo episodio';
        }
    } else if (isset($_POST['episodioId']) && isset($_POST['valor'])) {
        $respuesta = $_series->actualizarValorEpisodio($_POST['episodioId'], $_POST['valor']);
        
        if ($respuesta) {
            echo json_encode($respuesta);
        } else {
            echo 'Error! No se actualizo el valor del episodio';
        }
    } else if (isset($_POST['action'])) {
        if ($_POST['action'] == 'actualizar_info') {
            $postBody = array();
            foreach ($_POST as $key => $value) {
                // Process each field received via FormData
                $postBody[$key] = $value;
            }
            if ($_FILES['imagen']['error'] === UPLOAD_ERR_INI_SIZE) {
                // Handle the file size error
                echo 'Error_Max';
            } else {
                foreach ($_FILES as $key => $value) {
                    $postBody[$key] = $value;
                }
                
                $datosArray = $_series->actualizarInfoEpisodio($postBody);
                echo "Actualizado " . json_encode($datosArray);
            }
            
            
        } else if ($_POST['action'] == 'eliminar_episodio') {
            if (isset($_POST['id_episodio'])) {
                $respuesta = $_series->eliminarEpisodio($_POST['id_episodio']);
                if ($respuesta) {
                    echo json_encode($respuesta);
                } else {
                    echo 'Error! No se pudo eliminar el episodio';
                }
            }
        }
    } 


    
}

?>