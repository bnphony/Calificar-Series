<?php
session_start();
require_once "../clases/series.class.php";

$_series = new series;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'subir_data') {
            if (isset($_POST['data'])) {
                $jsonBody = json_decode($_POST['data'], true);  
                $idCategoria = $_SESSION['id_categoria'];              
                $arrayData = $_series->subirDataJsonFile($jsonBody, $idCategoria);
                echo json_encode($arrayData);
            }
        }
        
    }
}
?>