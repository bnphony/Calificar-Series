<?php 
require_once "../clases/categoria.class.php";

$_categorias = new categorias;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['pagina'])) {
        $pagina = $_GET['pagina'];
        $data = $_categorias->listaCategorias($pagina);
        header("Content-Type: application/json");
        echo json_encode($data);
        http_response_code(200);
    } else if (isset($_GET["action"])) {
        $arrayData = $_categorias->buscarCategoria();
        header("Content-Type: application/json");
        echo json_encode($arrayData);
        http_response_code(200);
    }
    
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'registrar_categoria') {
            if (isset($_POST['nombre_categoria'])) {
                $dataArray = $_categorias->addCategoria($_POST['nombre_categoria']);
                echo json_encode($dataArray);
            }
        } else if ($_POST['action'] == 'actualizar_categoria') {
            $postBody = array();
            foreach ($_POST as $key => $value) {
                $postBody[$key] = $value;
            }
            $dataArray = $_categorias->actualizarCategoria($postBody);
            echo json_encode($dataArray);
            http_response_code(200);
        }
        if ($_POST['action'] == 'eliminar_categoria') {
           if (isset($_POST['id_categoria'])) {
                $respuesta = $_categorias->eliminarCategoria($_POST['id_categoria']);
                if ($respuesta) {
                    echo json_encode($respuesta);
                } else {
                    echo 'Error! No se pudo eliminar la Categoria';
                }
           } 
        }
    }
}
?>