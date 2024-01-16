<?php 
session_start();
require_once "../clases/series.class.php";

$_series = new series;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET["page"])) {
        $data = array();
        $info = array();
        $nodos = array();
        $pagina = $_GET["page"];
        $listaSeries = $_series->listaSeries($pagina, $_SESSION['id_categoria']);
        foreach ($listaSeries as $value) {
            $info['INFO'] = $value;
            $info['NODOS'] = $_series->listaEpisodios($value['id']);
            $data[] = $info;
        }
        header("Content-Type: application/json");
        echo json_encode($data);
        http_response_code(200);
    }    
}
?>